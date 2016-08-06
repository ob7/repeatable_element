<?php
namespace Concrete\Package\RepeatableElement\Block\RepeatableElement;

use Concrete\Core\Block\BlockController;
use Database;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;

class Controller extends BlockController

{
    protected $btTable = 'btRepeatableElement';
    protected $btInterfaceWidth = "992";
    protected $btInterfaceHeight = "650";
    protected $btWrapperClass = "ccm-ui";
    protected $btIgnorePageThemeGridFrameworkContainer = true;
    protected $btDefaultSet = 'basic';

    public function getBlockTypeName()
    {
        return t('Repeatable Element');
    }

    public function getBlockTypeDescription()
    {
        return t('Create blocks containing repeatable elements for different uses, such as slideshows or multi-location maps.');
    }

    // add block duplicate function

    //

    public function add()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('redactor');
        $this->set('bf', null);

        if(!$this->displayTitle) {
            $displayTitle = 1;
        }
        $this->set('displayTitle', $displayTitle);
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('redactor');
        $db = Database::connection();
        $q = 'SELECT * from btRepeatableItem WHERE bID = ? ORDER BY sortOrder';
        $query = $db->fetchAll($q, array($this->bID));
        $this->set('items', $query);

        $bf = null;
        if ($this->getFileID() > 0) {
            $bf = $this->getFileObject();
        }
        $this->set('bf', $bf);
    }

    public function getFileID()
    {
        return $this->sfID;
    }

    public function getFileObject()
    {
        return File::getByID($this->sfID);
    }

    public function view()
    {
        $this->set('items', $this->getEntries());

        $sf = File::getByID($this->sfID);
        $this->set('sf', $sf);

    }

	public function on_start()
    {
        if($this->enableLocations > 0) {
            $this->requireAsset('googleMapsAPI');
            $this->requireAsset('locationsStyle');
        }
        if($this->enableSlideshow > 0) {
            $this->requireAsset('cycle2');
        }
	  }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btRepeatableItem', array('bID' => $this->bID));
        parent::delete();
    }

    public function getEntries()
    {
        $db = Database::connection();
        $q = 'SELECT * from btRepeatableItem WHERE bID = ? ORDER BY sortOrder';
        $rows = $db->fetchAll($q, array($this->bID));
        $items = array();
        foreach ($rows as $row) {
            if(!$row['linkURL'] && $row['internalLinkCID']) {
                $c = Page::getByID($row['internalLinkCID'], 'ACTIVE');
                $row['linkURL'] = $c->getCollectionLink();
                $row['linkPage'] = $c;
            }
            $row['description'] = LinkAbstractor::translateFrom($row['description']);
            $items[] = $row;
        }

        return $items;
    }

	// function to geocode address, it will return false if unable to geocode address
	public function geocode($address){
		// url encode the address
		$address = urlencode($address);
		// google map geocode api url
		$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
		// get the json response
		$resp_json = file_get_contents($url);
		// decode the json
		$resp = json_decode($resp_json, true);
		// response status will be 'OK', if able to geocode given address 
		if($resp['status']=='OK'){
			// get the important data
			$lati = $resp['results'][0]['geometry']['location']['lat'];
			$longi = $resp['results'][0]['geometry']['location']['lng'];
			$formatted_address = $resp['results'][0]['formatted_address'];
			// verify if data is complete
			if($lati && $longi && $formatted_address){
				// put the data in the array
				$data_arr = array();
				array_push(
					$data_arr,
						$lati,
						$longi,
						$formatted_address
					);

				return $data_arr;

			}else{
				return false;
			}

		}else{
			return false;
		}
	}

    public function save($data)
    {
        $data['displayTitle'] = intval($data['displayTitle']);
        $data['enableImage'] = intval($data['enableImage']);
        $data['enableLinks'] = intval($data['enableLinks']);
        $data['cropImage'] = intval($data['cropImage']);
        $data['crop'] = intval($data['crop']);
        $data['enableSlideshow'] = intval($data['enableSlideshow']);
        $db = Database::connection();
        $q = 'DELETE from btRepeatableItem WHERE bID = ?';
        $db->executeQuery($q, array($this->bID));
        parent::save($data);
        if (isset($data['sortOrder'])) {
            $count = count($data['sortOrder']);
            $i = 0;

            while ($i < $count) {
                $linkURL = $data['linkURL'][$i];
                $internalLinkCID = $data['internalLinkCID'][$i];
                switch (intval($data['linkType'][$i])) {
                    case 1:
                        $linkURL = '';
                        break;
                    case 2:
                        $internalLinkCID = 0;
                        break;
                    default:
                        $linkURL = '';
                        $internalLinkCID = 0;
                        break;
                }
                if(isset($data['description'][$i])) {
                    $data['description'][$i] = LinkAbstractor::translateTo($data['description'][$i]);
                }

                $q = 'INSERT INTO btRepeatableItem (bID, fID, title, linkURL, internalLinkCID, description, sortOrder, addressLine1, addressLine2, city, state, zip, country, locationLink, lat, lng, fullAddress) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

				//if (!$data['lat'][$i] <= 0 || $data['lng'][$i] <= 0) {
					$address = $data['addressLine1'][$i] . ', ' . $data['addressLine2'][$i] . ', ' . $data['city'][$i] . ', ' . $data['state'][$i] . ', ' . $data['zip'][$i] . ', ' . $data['country'][$i];
					$addressLocation = $this->geocode($address);
					$lat = $addressLocation[0];
					$lng = $addressLocation[1];
					$fullAddress = $addressLocation[2];
				//} else {
					//$lat = 0;
					//$lng = 0;
				//}
                $db->executeQuery($q,
                    array(
                        $this->bID,
                        intval($data['fID'][$i]),
                        $data['title'][$i],
                        $linkURL,
                        $internalLinkCID,
                        $data['description'][$i],
                        $data['sortOrder'][$i],
                        $data['addressLine1'][$i],
                        $data['addressLine2'][$i],
                        $data['city'][$i],
                        $data['state'][$i],
                        $data['zip'][$i],
                        $data['country'][$i],
                        $data['locationLink'][$i],
                        $lat,
                        $lng,
                        $fullAddress
                    )
                );
                ++$i;
            }
        }
    }
}
