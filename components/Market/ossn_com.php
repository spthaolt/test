<?php
define('__MARKET__', ossn_route()->com . 'Market/');
require_once(__MARKET__ . 'classes/Market.php');

function market_init()
{
	ossn_register_page('market', 'market_page');
	ossn_extend_view('css/ossn.default', 'css/market');
	ossn_extend_view('js/opensource.socialnetwork', 'js/market');
	$emojii_button = array(
			'name' => 'product',
			'text' => '<i class="fa fa-cart-plus"></i>',
			'href' => 'javascript:void(0);',
	);
	ossn_register_menu_item('wall/container/controls/home', $emojii_button);
}

function market_page($pages)
{
	$market = new Market;

	if(!ossn_isLoggedin()) {
		ossn_error_page();
	}
	$page = $pages[0];
	if(empty($page)) {
		$page = 'view';
	}
	switch($page) {
		case 'view':
			var_dump($market->get(1));
			die('as');
			$params['test'] = "abc";
			echo ossn_plugin_view('market/pages/view', $params);
			break;
		default:
			ossn_error_page();
			break;
	}
}

ossn_register_callback('ossn', 'init', 'market_init');
