<?php
namespace Concrete\Package\RepeatableElement;

use Package;
use BlockType;

class Controller extends Package
{
    protected $pkgHandle = 'repeatable_element';
    protected $appVersionRequired = '5.7.5.1';
    protected $pkgVersion = '0.9';

    public function getPackageName()
    {
        return t('Repeatable Element');
    }

    public function getPackageDescription()
    {
        return t('Installs the Repeatable Items block for creating blocks that contain various types of repeatable items for different scenarios.');
    }

    public function install()
    {
        $pkg = parent::install();
        $bt = BlockType::getByHandle('repeatable_element');
        if (!is_object($bt)) {
            $bt = BlockType::installBlockType('repeatable_element', $pkg);
        }
    }

}
