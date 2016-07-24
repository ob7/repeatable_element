<?php
namespace Concrete\Package\RepeatableElement\Block\RepeatableElement;

use Concrete\Core\Block\BlockController;
use Database;
use Page;
use Core;

class Controller extends BlockController
{
    protected $btTable = 'btRepeatableElement';
    protected $btInterfaceWidth = "800";
    protected $btInterfaceHeight = "650";
    protected $btWrapperClass = "ccm-ui";
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    public function getBlockTypeName()
    {
        return t('Repeatable Element');
    }

    public function getBlockTypeDescription()
    {
        return t('Repeatable Dynamic Items Starter Block');
    }

    public function add()
    {
    }

    public function edit()
    {
        $db = Database::connection();
        $query = $db->GetAll('SELECT * from btRepeatableItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));
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
        $rows = $db->GetAll('SELECT * from btRepeatableItem WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $items = array();
        foreach ($rows as $row) {
            $items[] = $row;
        }

        return $items;
    }

    public function save($data)
    {
        $db = Database::connection();
        $db->execute('DELETE from btRepeatableItem WHERE bID = ?', array($this->bID));
        parent::save($data);
        if (isset($data['sortOrder'])) {
            $count = count($data['sortOrder']);
            $i = 0;

            while ($i < $count) {
                $title = $data['title'][$i];
                $db->execute('INSERT INTO btRepeatableItem (bID, title, sortOrder) values(?,?,?)',
                    array(
                        $this->bID,
                        $data['title'][$i],
                        $data['sortOrder'][$i],
                    )
                );
                ++$i;
            }
        }
    }
}
