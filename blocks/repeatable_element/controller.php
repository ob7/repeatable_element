<?php
namespace Concrete\Package\RepeatableElement\Block\RepeatableElement;

use Concrete\Core\Block\BlockController;
use Database;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
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
        return t('Create blocks containing repeatable elements for different uses, such as slideshows or multi-location maps.');
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('redactor');

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
            $row['description'] = LinkAbstractor::translateFrom($row['description']);
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
                if(isset($data['description'][$i])) {
                    $data['description'][$i] = LinkAbstractor::translateTo($data['description'][$i]);
                }
                $q = 'INSERT INTO btRepeatableItem (bID, fID, title, description, sortOrder) values(?,?,?,?,?)';
                $db->executeQuery($q,
                    array(
                        $this->bID,
                        intval($data['fID'][$i]),
                        $data['title'][$i],
                        $data['description'][$i],
                        $data['sortOrder'][$i],
                    )
                );
                ++$i;
            }
        }
    }
}
