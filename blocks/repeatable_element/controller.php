<?php
namespace Concrete\Package\RepeatableElement\Block\RepeatableElement;

use Concrete\Core\Block\BlockController;
use Database;
use Page;
use Core;
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
        return t('Repeatable Dynamic Items Starter Block');
    }

    // add block duplicate function

    //

    public function add()
    {
        $this->requireAsset('core/file-manager');

        if(!$this->displayTitle) {
            $displayTitle = 1;
        }
        $this->set('displayTitle', $displayTitle);
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $db = Database::connection();
        $q = 'SELECT * from btRepeatableItem WHERE bID = ? ORDER BY sortOrder';
        $query = $db->fetchAll($q, array($this->bID));
        $this->set('items', $query);

    }

    public function view()
    {
        $this->set('items', $this->getEntries());
    }

	public function on_start()
	{
		if($this->enableLocations > 0) {
			$this->requireAsset('googleMapsAPI');
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
        $data['cropImage'] = intval($data['cropImage']);
        $data['crop'] = intval($data['crop']);
        $db = Database::connection();
        $q = 'DELETE from btRepeatableItem WHERE bID = ?';
        $db->executeQuery($q, array($this->bID));
        parent::save($data);
        if (isset($data['sortOrder'])) {
            $count = count($data['sortOrder']);
            $i = 0;

            while ($i < $count) {
                $q = 'INSERT INTO btRepeatableItem (bID, fID, title, sortOrder, addressLine1, addressLine2, city, state, zip, country, lat, lng, fullAddress) values(?,?,?,?,?,?,?,?,?,?,?,?,?)';

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
                        $data['sortOrder'][$i],
                        $data['addressLine1'][$i],
                        $data['addressLine2'][$i],
                        $data['city'][$i],
                        $data['state'][$i],
                        $data['zip'][$i],
                        $data['country'][$i],
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
