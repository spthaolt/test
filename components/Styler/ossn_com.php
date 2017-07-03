<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('STYLER', ossn_route()->com . 'Styler/');
function styler_init() {
		ossn_register_com_panel('Styler', 'settings');
		$component = new OssnComponents;
		$settings  = $component->getSettings('Styler');
		
		$colors = styler_colors();
		foreach($colors as $item) {
				ossn_new_css("styler.{$item}", "css/styler/{$item}");
		}
		
		if(isset($settings->styler) && $settings->styler !== 'blue') {
				ossn_load_css("styler.{$settings->styler}");
		}
		
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('styler/save', STYLER . 'actions/save.php');
				
		}
		ossn_unregister_menu('powered', 'footer');
		ossn_extend_view('css/ossn.admin.default', 'css/stylercss');
		ossn_unload_external_js('jquery-arhandler-1.1-min.js');
}
/**
 * Setup some default colors
 *
 * @param null
 * @return void
 */
function styler_colors() {
		$colors = array(
				'montego',
				'blue',
				'green',
				'red',
				'pink',
				'brown',
				'darkyellow'
		);
		sort($colors);
		return $colors;
}
ossn_register_callback('ossn', 'init', 'styler_init');
