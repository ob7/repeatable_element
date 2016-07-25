<?php
namespace Concrete\Package\RepeatableElement;

use Package;
use BlockType;

class Controller extends Package
{
    protected $pkgHandle = 'repeatable_element';
    protected $appVersionRequired = '5.7.5.8';
    protected $pkgVersion = '0.9';

    public function getPackageName()
    {
        return t('Repeatable Item Template');
    }

    public function getPackageDescription()
    {
        return t('Starter package for making a block with repeatable items');
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
