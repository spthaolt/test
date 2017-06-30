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
define('BIRTHDAYS', ossn_route()->com . 'Birthdays/');
/**
 * Birthday component init
 *
 * @param null
 * @return void
 */
function birthdays_init() {
		ossn_add_hook('newsfeed', "sidebar:right", 'ossn_birthdays_newsfeed', 1);
		ossn_extend_view('css/ossn.default', 'css/birthdays');
}
/**
 * Birthday component display on newsfeed sidebar
 *
 * @param string $hook A name of hook
 * @param string $type A type of hook
 * @param array  $return A mixed data arrays
 *
 * @return array
 */
function ossn_birthdays_newsfeed($hook, $type, $return) {
		$return[] = ossn_plugin_view('widget/view', array(
				'title' => ossn_print('birthdays:upcoming'),
				'contents' => ossn_plugin_view('birthdays/newsfeed'),
				'class' => 'birthdays'
		));
		return $return;
}
/**
 * Get user friend birthdays
 *
 * @param object  $user OssnUser object
 * @param integer $inmonth Birthday in x months
 * @param integer $limit Default limit is 5
 *
 * @return array
 */
function ossn_get_upcomming_birthdays($user = '', $inmonths = 4, $limit = 5) {
		if($user instanceof OssnUser) {
				$friends = $user->getFriends();
				if($friends) {
						foreach($friends as $item) {
								$guids[] = $item->guid;
						}
				}
				$months   = array();
				$months[] = date('m', time());
				if($inmonths <= 1) {
						$inmonths = $inmonths - 1;
				}
				foreach(range(1, $inmonths) as $item) {
						if(empty($dd)) {
								$dd = time();
						} else {
								$dd = strtotime("+1 MONTH", $dd);
						}
						$months[] = date('m', strtotime("+1 MONTH", $dd));
				}
				$months = implode(',', $months);
				if(!empty($guids)) {
						$guids = implode(',', $guids);
						$time  = time();
						return $user->searchUsers(array(
								'entities_pairs' => array(
										
										array(
												'name' => 'birthdate',
												'wheres' => "MONTH(STR_TO_DATE(emd0.value, '%d/%m/%Y')) IN ({$months})",
												'value' => true
										)
								),
								'limit' => $limit,
								'order_by' => "emd0.value DESC",
								'wheres' => "u.guid IN ({$guids})"
						));
				}
		}
		return false;
}
ossn_register_callback('ossn', 'init', 'birthdays_init');