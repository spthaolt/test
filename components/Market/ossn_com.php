<?php
define('__MARKET__', ossn_route()->com . 'Market/');
require_once(__MARKET__ . 'classes.php');
use Market\catalog\Product;
use Market\catalog\Shop;
use Market\catalog\ShopEntity;

define('SHOP_URL', ossn_site_url('s/'));
define('ACTION_URL', ossn_site_url('action/'));

function market_init()
{
	ossn_register_page('s', 'market_pages_handler');
	ossn_extend_view('css/ossn.default', 'css/breadcrumbs');
	ossn_extend_view('js/opensource.socialnetwork', 'js/market');
	$emojii_button = array(
		'name' => 'product',
		'text' => '<i class="fa fa-cart-plus"></i>',
		'href' => 'javascript:void(0);',
		);
	$container_controls = array(
			array(
				'name' => 'tag_friend',
				'class' => 'ossn-wall-friend',
				'text' => '<i class="fa fa-users"></i>',
			),
			array(
				'name' => 'location',
				'class' => 'ossn-wall-location',
				'text' => '<i class="fa fa-map-marker"></i>',
			),
			array(
				'name' => 'photo',
				'class' => 'ossn-wall-photo',
				'text' => '<i class="fa fa-picture-o"></i>',
			),			
		);	
	ossn_unregister_menu_item('photo','photo','wall/container/controls/home');
	
	ossn_register_menu_item('wall/container/controls/home', $emojii_button);
	ossn_add_hook('market', 'post', 'market_wallpost_add', 1);

	ossn_register_action('s/request/info', __MARKET__ . 'actions/shop/request_info.php');
	ossn_register_action('s/request/owner', __MARKET__ . 'actions/shop/request_owner.php');
	ossn_register_action('s/request/confirm', __MARKET__ . 'actions/shop/request_confirm.php');
}

function market_wallpost_add($hook,$type,$return,$params)
{
	$product = new Product;
	$product->owner_guid  = ossn_loggedin_user()->guid;
	$product->poster_guid = ossn_loggedin_user()->guid;

	if ($product->post($params)) {
		$type = "success";
	} else {
		$type = "error";
	}
	$guid = $product->getObjectId();
	$get  = $product->GetPost($guid);

	$data[$type] = array(ossn_print('post:created'));
	$data['data']['post'] = wall_view_template(wallpost_to_item($get));
	echo json_encode($data);
}

function market_pages_handler($pages)
{
	$user = ossn_loggedin_user();
	$product = new Product;

	if(!ossn_isLoggedin()) {
		ossn_error_page();
	}

	$page = $pages[0];
	if(empty($page)) {
		$page = 'view';
	}

	// Object manager
	$om = new \OssnObject();

	switch($page) {
		case 'request':
			$om->owner_guid = ossn_loggedin_user()->guid;
			$om->type = 'user';
			$om->subtype = 'market:shop';
			$params['data'] = $om->getObjectByOwner();
			$step = $_GET['step'];
			if (!isset($step)) {
				$step = 'info';
			}
			$params['step'] = $step;
			switch ($step) {
				case 'info':
					$form = array(
						'action' => ACTION_URL.'s/request/info',
						'component' => 'Market',
						'class' => 'ossn-form',
						'params' => $params
					);
					$params['form']   = ossn_view_form('shop/request_info', $form, false);
					break;
				case 'owner':
					$form = array(
						'action' => ACTION_URL.'/s/request/owner',
						'component' => 'Market',
						'class' => 'ossn-form',
						'params' => $params
					);
					$params['form']   = ossn_view_form('shop/request_owner', $form, false);
					break;
				case 'confirm':
					$form = array(
						'action' => ACTION_URL.'/s/request',
						'component' => 'Market',
						'class' => 'ossn-form',
						'params' => $params
					);
					$params['form']   = ossn_view_form('shop/request_confirm', $form, false);
					break;
				default:
					ossn_error_page();
					break;
			}
			$content  = ossn_plugin_view("market/pages/shop/request", $params);
			echo ossn_view_page($title, $content);
			break;
		case 'view':
			$posts = $product->getAllByOwnerGUID($user->guid);
			$params['content'] = "";
			if($posts) {
				foreach($posts as $post) {
					$item = wallpost_to_item($post);
					$params['content'] .= wall_view_template($item);
				}
			}
			$content  = ossn_plugin_view("market/layout/newsfeed", $params);
			echo ossn_view_page($title, $content);
			break;
		default:
			$vars = array(
				'type' => 'user',
				'subtype' => 'market:shop',
				'name' => array('title'),
				'entities_pairs' => array(
					array(
						'name' => 'friendly_url',
						'value' => $page
					)
				),
				'count' => false,
			);

			$shop = $om->searchObject($vars);
			if (!$shop) ossn_error_page();			

			$content  = ossn_plugin_view("market/layout/shop", $shop);
			echo ossn_view_page($title, $content);

			var_dump($shop->searchObject($vars));
			die('ossncom');
			break;
	}
}

function wallpost_to_item($post) 
{
	if($post && $post instanceof Product) {
		if(!isset($post->poster_guid)) {
			$post = ossn_get_object($post->guid);
		}
		$data     = json_decode(html_entity_decode($post->description));
		$text     = ossn_restore_new_lines($data->post, true);
		$location = '';

		if(isset($data->location)) {
			$location = '- ' . $data->location;
		}
		if(isset($post->{'file:wallphoto'})) {
			$image = str_replace('ossnwall/images/', '', $post->{'file:wallphoto'});
		} else {
			$image = '';
		}

		$user = ossn_user_by_guid($post->poster_guid);
		return array(
			'post' => $post,
			'friends' => explode(',', $data->friend),
			'text' => $text,
			'location' => $location,
			'user' => $user,
			'image' => $image
			);
	}
	return false;
}

function wall_view_template(array $params = array()) 
{
	if(!is_array($params)){
		return false;
	}
	$type = $params['post']->type;
	if(isset($params['post']->item_type)) {
		$type = $params['post']->item_type;
	}
	return ossn_plugin_view('market/wall/template/wall/item', $params);
}

ossn_register_callback('ossn', 'init', 'market_init');
