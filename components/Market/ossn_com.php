<?php
define('__MARKET__', ossn_route()->com . 'Market/');
require_once(__MARKET__ . 'classes/Product.php');

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
	// foreach($container_controls as $key => $container_control){
	// 		ossn_unregister_menu_item($container_control['name'],'wall/container/controls/home');		
	// }
	ossn_unregister_menu_item('photo','photo','wall/container/controls/home');
	
	ossn_register_menu_item('wall/container/controls/home', $emojii_button);
	ossn_register_action('market/post', __MARKET__ . 'actions/post.php');
	ossn_add_hook('market', 'post', 'market_wallpost_add', 1);
}

function market_wallpost_add($hook,$type,$return,$params)
{
	$product = new Product;
	$product->owner_guid  = ossn_loggedin_user()->guid;
	$product->poster_guid = ossn_loggedin_user()->guid;

//check if owner guid is zero then exit
	if($product->owner_guid == 0 || $product->poster_guid == 0) {
		ossn_trigger_message(ossn_print('post:create:error'), 'error');
		redirect(REF);
	}
	$product->post($params);
	return $product;
}

function market_page($pages)
{
	$product = new Product;

	if(!ossn_isLoggedin()) {
		ossn_error_page();
	}
	$page = $pages[0];
	if(empty($page)) {
		$page = 'view';
	}
	switch($page) {
		case 'view':
			$posts = $product->get(1);
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
			ossn_error_page();
			break;
	}
}

function wallpost_to_item($post) {
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

function wall_view_template(array $params = array()) {
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
