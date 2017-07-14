<?php
global $ComposerLoader;

$namespaces = array(
	'catalog' => array('Shop','Category','Manufacturer','Order','Price','Product','Review','Voucher'),
	'bol' => array('ShopsService','CategoriesService','ManufacturersService','OrdersService','PricesService','ProductsService','ReviewsService','VouchersService'),
);

foreach ($namespaces as $key => $classes) {
	foreach ($classes as $class) {
		$ComposerLoader->addClassMap(array(
			'Market\\'.$key.'\\'.$class => dirname(__FILE__).'/classes/'.$key.'/'.$class.'.php'
		));
	}
}