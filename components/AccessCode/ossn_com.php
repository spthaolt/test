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
define('ACCESS_CODE', ossn_route()->com . 'AccessCode/');

/**
 * Access code init
 * 
 * @return void
 */
function access_code() {
		ossn_register_com_panel('AccessCode', 'settings');
		ossn_extend_view('forms/signup/before/submit', 'accesscode/input');
		ossn_register_callback('action', 'load', 'access_code_check');
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('accesscode/settings', ACCESS_CODE . 'actions/settings.php');
		}
}
/**
 * Validate the register actions
 *
 * @param string $callback  The callback type
 * @param string $type      The callback type
 * @param array  $params    The option values
 * 
 * @return string
 */
function access_code_check($callback, $type, $params) {
		$code      = input('access_code');
		$component = new OssnComponents;
		$settings  = $component->getSettings('AccessCode');
		if(isset($params['action']) && $code !== $settings->accesscode) {
				if($params['action'] == 'user/register') {
						header('Content-Type: application/json');
						echo json_encode(array(
								'dataerr' => ossn_print('access:code:error')
						));
						exit;
				}
		}
}
ossn_register_callback('ossn', 'init', 'access_code');