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

	public function on_start()
	{
		$al = \Concrete\Core\Asset\AssetList::getInstance();
		$al->register(
		'javascript', 'googleMapsAPI', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC_eOliAR35peqAtdN6NquzIMQinPqwx5Q&callback=initMap', array('local' => false)
		);

		$al->register(
			'javascript', 'gmapsjs', 'blocks/repeatable_element/vendor/hpneo/gmaps.js', array(), 'repeatable_element'
		);

		$al->register(
			'css', 'locationsStyle', 'blocks/repeatable_element/layouts/locations/layout.css', array(), 'repeatable_element'
		);

		$al->registerGroup('googleMapsAPI',array(
			array('javascript','gmapsjs'),
			array('javascript','googleMapsAPI'),
		));

		$al->registerGroup('locationsStyle',array(
			array('css','locationsStyle'),
		));
	}

}
