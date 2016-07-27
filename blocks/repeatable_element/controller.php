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
                $q = 'INSERT INTO btRepeatableItem (bID, fID, title, sortOrder, addressLine1, addressLine2, city, state, zip, country) values(?,?,?,?,?,?,?,?,?,?)';
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
                        $data['country'][$i]
                    )
                );
                ++$i;
            }
        }
    }
}
