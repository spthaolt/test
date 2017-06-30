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
define('EVENTS', ossn_route()->com . 'Events/');

require_once(EVENTS . 'classes/Events.php');
/**
 * Events init
 *
 * @return void
 */
function events_init() {
		if(ossn_isLoggedin()) {
				ossn_register_action('event/add', EVENTS . 'actions/add.php');
				ossn_register_action('event/edit', EVENTS . 'actions/edit.php');
				ossn_register_action('event/decision', EVENTS . 'actions/relation.php');
				ossn_register_action('event/delete', EVENTS . 'actions/delete.php');
		}
		ossn_register_page("event", 'event_page_handler');
		
		ossn_extend_view('css/ossn.default', 'css/events');
		ossn_extend_view('js/opensource.socialnetwork', 'js/events');
		
		ossn_new_external_js('datetime.js', 'components/Events/vendors/datetime/js/bootstrap-datetimepicker.min.js');
		ossn_new_external_css('datetime.css', 'components/Events/vendors/datetime/css/bootstrap-datetimepicker.min.css');
		
		ossn_register_callback('page', 'load:profile', 'ossn_profile_events_menu');
		ossn_register_sections_menu('newsfeed', array(
				'name' => 'events_all',
				'text' => ossn_print('event:all'),
				'url' => ossn_site_url('event/list'),
				'section' => 'event',
				'icon' => true
		));
		$user = ossn_loggedin_user();
		ossn_register_sections_menu('newsfeed', array(
				'name' => 'events_my',
				'text' => ossn_print('event:mine'),
				'url' => ossn_site_url('event/list/') . $user->guid,
				'section' => 'event',
				'icon' => true
		));
		ossn_register_sections_menu('newsfeed', array(
				'name' => 'events_add',
				'text' => ossn_print('event:add'),
				'url' => ossn_site_url('event/add'),
				'section' => 'event',
				'icon' => true
		));
		
		ossn_add_hook('search', 'type:event', 'event_search_handler');
		ossn_add_hook('notification:add', 'event:relation:going', 'ossn_notificaiton_event_interests');
		ossn_add_hook('notification:add', 'event:relation:interested', 'ossn_notificaiton_event_interests');
		ossn_add_hook('notification:add', 'event:relation:nointerested', 'ossn_notificaiton_event_interests');
		ossn_add_hook('notification:view', 'event:relation:going', 'ossn_notification_event_view');
		ossn_add_hook('notification:view', 'event:relation:interested', 'ossn_notification_event_view');
		ossn_add_hook('notification:view', 'event:relation:nointerested', 'ossn_notification_event_view');
		ossn_add_hook('notification:view', 'comments:entity:event:wall', 'ossn_notification_event_comment_like_view');
		ossn_add_hook('notification:view', 'like:entity:event:wall', 'ossn_notification_event_comment_like_view');
		ossn_add_hook('notification:view', 'like:annotation', 'ossn_notification_event_comment_like_view');
		ossn_add_hook('wall:template', 'event', 'ossn_wall_event_item');
		
		ossn_register_callback('page', 'load:search', 'ossn_event_search_link');
		ossn_register_callback('user', 'delete', 'ossn_user_events_delete');
}

/**
 * Events notification view for comment and like
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return mixed data
 */
function ossn_notification_event_comment_like_view($hook, $type, $return, $params) {
		$notif = $params;
		
		$entity = ossn_get_entity($notif->subject_guid);
		if(($notif->type == 'like:annotation' && $entity->subtype == 'event:wall') || $notif->type == 'comments:entity:event:wall' || $notif->type == 'like:entity:event:wall') {
				
				$subject        = ossn_get_event($entity->owner_guid);
				$baseurl        = ossn_site_url();
				$user           = ossn_user_by_guid($notif->poster_guid);
				$user->fullname = "<strong>{$user->fullname}</strong>";
				$iconURL        = $user->iconURL()->small;
				
				$img  = "<div class='notification-image'><img src='{$iconURL}' /></div>";
				$type = "<div class='ossn-notification-icon-calander'></div>";
				if($notif->viewed !== NULL) {
						$viewed = '';
				} elseif($notif->viewed == NULL) {
						$viewed = 'class="ossn-notification-unviewed"';
				}
				
				$url               = $subject->profileURL();
				$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
				return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . ossn_print("ossn:notifications:{$notif->type}", array(
						$user->fullname
				)) . '</div>
		   </div></li>';
		}
}
/**
 * Events notification view for event relations
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return mixed data
 */
function ossn_notification_event_view($hook, $type, $return, $params) {
		$notif          = $params;
		$baseurl        = ossn_site_url();
		$user           = ossn_user_by_guid($notif->poster_guid);
		$user->fullname = "<strong>{$user->fullname}</strong>";
		$iconURL        = $user->iconURL()->small;
		
		$img  = "<div class='notification-image'><img src='{$iconURL}' /></div>";
		$type = "<div class='ossn-notification-icon-calander'></div>";
		if($notif->viewed !== NULL) {
				$viewed = '';
		} elseif($notif->viewed == NULL) {
				$viewed = 'class="ossn-notification-unviewed"';
		}
		
		$subject           = ossn_get_event($notif->subject_guid);
		$url               = $subject->profileURL();
		$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . ossn_print("ossn:notifications:{$notif->type}", array(
				$user->fullname
		)) . '</div>
		   </div></li>';
}
/**
 * Add a notfication for event relations
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return array
 */
function ossn_notificaiton_event_interests($hook, $type, $return, $params) {
		return array_merge($params, array(
				'owner_guid' => $params['notification_owner'],
				'item_guid' => $params['subject_guid']
		));
}
/**
 * Add a search event like in search page sidebar
 *
 * @param string $event A name of event
 * @param string $type A event type
 * @param array $params A option values
 *
 * @return void
 */
function ossn_event_search_link($event, $type, $params) {
		$url = OssnPagination::constructUrlArgs(array(
				'type'
		));
		ossn_register_menu_link('event', 'event', "search?type=event{$url}", 'search');
}
/**
 * Events search page handler
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return string
 */
function event_search_handler($hook, $type, $return, $params) {
		$events = new Events;
		$list   = $events->getEvents(array(
				'wheres' => "o.title LIKE '%{$params['q']}%'"
		));
		$count  = $events->getEvents(array(
				'count' => true
		));
		return ossn_plugin_view('event/pages/search', array(
				'list' => $list,
				'count' => $count
		));
}
/**
 * Get event from guid
 *
 * @param integer $guid A guid
 *
 * @return object|boolean
 */
function ossn_get_event($guid) {
		if(!empty($guid)) {
				if($object = ossn_get_object($guid)) {
						if($object->subtype == 'event') {
								$array = (array) $object;
								return arrayObject($array, 'Events');
						}
				}
		}
		return false;
}
/**
 * Event default relationships
 *
 * @return array
 */
function ossn_events_relationship_default() {
		return array(
				'event:interested',
				'event:going',
				'event:nointerested'
		);
}
/**
 * Event allowed comments or not
 *
 * @return array
 */
function ossn_events_comments_allowed() {
		return array(
				true => ossn_print('events:comments:allowed'),
				false => ossn_print('events:comments:notallowed')
		);
}
/**
 * Template for event wall item
 *
 * @return mixed data;
 */
function ossn_wall_event_item($hook, $type, $return, $params) {
		return ossn_plugin_view("event/wall/item", $params);
}
/**
 * Event pagehandler
 *
 * @return mixedata
 */
function event_page_handler($pages) {
		$page = $pages[0];
		switch($page) {
				case 'image':
						if($object = ossn_get_object($pages[1])) {
								$name = str_replace(array(
										'.jpg',
										'.jpeg',
										'gif'
								), '', $pages[3]);
								
								$etag = $object->guid . $name;
								if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
										header("HTTP/1.1 304 Not Modified");
										exit;
								}
								
								$files = new OssnFile;
								
								$files->type       = 'object';
								$files->subtype    = 'event:photo';
								$files->owner_guid = $object->guid;
								
								$image = $files->getFiles();
								if(isset($image->{0}->guid)) {
										$file = $image->{0};
										switch($pages[2]) {
												case 'master':
														$binary = $file->getPath();
														break;
												case 'small':
														$val = $file->value;
														$val = str_replace('event/photo/', '', $val);
														$val = "small_{$val}";
														
														$binary = ossn_get_userdata("object/{$object->guid}/event/photo/{$val}");
														break;
										}
										if(is_file($binary)) {
												$filesize = filesize($binary);
												header("Content-type: image/jpeg");
												header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
												header("Pragma: public");
												header("Cache-Control: public");
												header("Content-Length: $filesize");
												header("ETag: \"$etag\"");
												readfile($binary);
										}
								}
						}
						break;
				case 'add':
						ossn_load_external_js('datetime.js');
						
						ossn_load_external_css('datetime.css');
						
						$title               = ossn_print('event:add');
						$contents['content'] = ossn_plugin_view('event/pages/add');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'view':
						if($event = ossn_get_event($pages[1])) {
								$title               = $event->title;
								$contents['content'] = ossn_plugin_view('event/pages/view', array(
										'event' => $event
								));
								$content             = ossn_set_page_layout('newsfeed', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				case 'edit':
						ossn_load_external_js('datetime.js');
						ossn_load_external_css('datetime.css');
						
						if($event = ossn_get_event($pages[1])) {
								$title               = ossn_print('event:edit');
								$contents['content'] = ossn_plugin_view('event/pages/edit', array(
										'event' => $event
								));
								$content             = ossn_set_page_layout('newsfeed', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				case 'relations':
						$type  = input('type');
						$event = ossn_get_event($pages[1]);
						if($event && !empty($type)) {
								switch($type) {
										case 1:
												$list  = (array) ossn_get_relationships(array(
														'to' => $event->guid,
														'type' => 'event:going'
												));
												$title = ossn_print('event:going');
												break;
										case 2:
												$list  = (array) ossn_get_relationships(array(
														'to' => $event->guid,
														'type' => 'event:interested'
												));
												$title = ossn_print('event:interested');
												break;
										case 3:
												$list  = (array) ossn_get_relationships(array(
														'to' => $event->guid,
														'type' => 'event:nointerested'
												));
												$title = ossn_print('event:nointerested');
												break;
								}
								
								if(!empty($list)) {
										foreach($list as $item) {
												if(!empty($item->relation_from)) {
														$users_guids[] = $item->relation_from;
												}
										}
										$guids = implode(',', $users_guids);
										if(!empty($users_guids)) {
												$users = new OssnUser;
												$lists = $users->searchUsers(array(
														'wheres' => "u.guid IN ({$guids})"
												));
										}
										echo ossn_plugin_view('output/ossnbox', array(
												'title' => $title,
												'contents' => '<div class="events-users-relations">' . ossn_plugin_view('output/users_list', array(
														'users' => $lists,
														'icon_size' => 'small'
												)) . '</div>',
												'control' => false
										));
								}
						} else {
								ossn_error_page();
						}
						break;
				case 'list':
						$events = new Events;
						
						if(!isset($pages[1])) {
								$list  = $events->getEvents();
								$count = $events->getEvents(array(
										'count' => true
								));
						} elseif(!empty($pages[1])) {
								$list  = $events->getEvents(array(
										'owner_guid' => $pages[1]
								));
								$count = $events->getEvents(array(
										'count' => true,
										'owner_guid' => $pages[1]
								));
						}
						
						$title               = ossn_print('event:list');
						$contents['content'] = ossn_plugin_view('event/pages/list', array(
								'list' => $list,
								'count' => $count
						));
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				default:
						ossn_error_page();
		}
}
/**
 * Event profile menu
 *
 * @param string $event A name of callback
 * @param string $type A event type
 * @param array  $params A option values
 *
 * @return void
 */
function ossn_profile_events_menu($event, $type, $params) {
		$guid = ossn_get_page_owner_guid();
		$url  = ossn_site_url();
		ossn_register_menu_item('user_timeline', array(
				'name' => 'event',
				'href' => ossn_site_url("event/list/{$guid}"),
				'text' => ossn_print('events')
		));
}
/**
 * Delete user events
 *
 * @param string $callback A name of callback
 * @param string $type A event type
 * @param array  $params A option values
 *
 * @return void
 */
function ossn_user_events_delete($callback, $type, $params) {
		if(!empty($params['entity']->guid)) {
				$events = new Events;
				$list   = $events->getEvents(array(
						'owner_guid' => $params['entity']->guid,
						'page_limit' => false
				));
				foreach($list as $item) {
						if($item->deleteObject()) {
								$list = (array) ossn_get_relationships(array(
										'to' => $item->guid,
										'type' => ossn_events_relationship_default()
								));
								if($list) {
										foreach($list as $item) {
												ossn_delete_relationship_by_id($item->relation_id);
										}
								}
						}
				}
		}
}
/**
 * A list of countries
 *
 * @return array
 */
function event_country_list() {
		$countries = array(
				"Afghanistan",
				"Albania",
				"Algeria",
				"American Samoa",
				"Andorra",
				"Angola",
				"Anguilla",
				"Antarctica",
				"Antigua and Barbuda",
				"Argentina",
				"Armenia",
				"Aruba",
				"Australia",
				"Austria",
				"Azerbaijan",
				"Bahamas",
				"Bahrain",
				"Bangladesh",
				"Barbados",
				"Belarus",
				"Belgium",
				"Belize",
				"Benin",
				"Bermuda",
				"Bhutan",
				"Bolivia",
				"Bosnia and Herzegowina",
				"Botswana",
				"Bouvet Island",
				"Brazil",
				"British Indian Ocean Territory",
				"Brunei Darussalam",
				"Bulgaria",
				"Burkina Faso",
				"Burundi",
				"Cambodia",
				"Cameroon",
				"Canada",
				"Cape Verde",
				"Cayman Islands",
				"Central African Republic",
				"Chad",
				"Chile",
				"China",
				"Christmas Island",
				"Cocos (Keeling) Islands",
				"Colombia",
				"Comoros",
				"Congo",
				"Congo, the Democratic Republic of the",
				"Cook Islands",
				"Costa Rica",
				"Cote d'Ivoire",
				"Croatia (Hrvatska)",
				"Cuba",
				"Cyprus",
				"Czech Republic",
				"Denmark",
				"Djibouti",
				"Dominica",
				"Dominican Republic",
				"East Timor",
				"Ecuador",
				"Egypt",
				"El Salvador",
				"Equatorial Guinea",
				"Eritrea",
				"Estonia",
				"Ethiopia",
				"Falkland Islands (Malvinas)",
				"Faroe Islands",
				"Fiji",
				"Finland",
				"France",
				"France Metropolitan",
				"French Guiana",
				"French Polynesia",
				"French Southern Territories",
				"Gabon",
				"Gambia",
				"Georgia",
				"Germany",
				"Ghana",
				"Gibraltar",
				"Greece",
				"Greenland",
				"Grenada",
				"Guadeloupe",
				"Guam",
				"Guatemala",
				"Guinea",
				"Guinea-Bissau",
				"Guyana",
				"Haiti",
				"Heard and Mc Donald Islands",
				"Holy See (Vatican City State)",
				"Honduras",
				"Hong Kong",
				"Hungary",
				"Iceland",
				"India",
				"Indonesia",
				"Iran (Islamic Republic of)",
				"Iraq",
				"Ireland",
				"Israel",
				"Italy",
				"Jamaica",
				"Japan",
				"Jordan",
				"Kazakhstan",
				"Kenya",
				"Kiribati",
				"Korea, Democratic People's Republic of",
				"Korea, Republic of",
				"Kuwait",
				"Kyrgyzstan",
				"Lao, People's Democratic Republic",
				"Latvia",
				"Lebanon",
				"Lesotho",
				"Liberia",
				"Libyan Arab Jamahiriya",
				"Liechtenstein",
				"Lithuania",
				"Luxembourg",
				"Macau",
				"Macedonia, The Former Yugoslav Republic of",
				"Madagascar",
				"Malawi",
				"Malaysia",
				"Maldives",
				"Mali",
				"Malta",
				"Marshall Islands",
				"Martinique",
				"Mauritania",
				"Mauritius",
				"Mayotte",
				"Mexico",
				"Micronesia, Federated States of",
				"Moldova, Republic of",
				"Monaco",
				"Mongolia",
				"Montserrat",
				"Morocco",
				"Mozambique",
				"Myanmar",
				"Namibia",
				"Nauru",
				"Nepal",
				"Netherlands",
				"Netherlands Antilles",
				"New Caledonia",
				"New Zealand",
				"Nicaragua",
				"Niger",
				"Nigeria",
				"Niue",
				"Norfolk Island",
				"Northern Mariana Islands",
				"Norway",
				"Oman",
				"Pakistan",
				"Palau",
				"Panama",
				"Papua New Guinea",
				"Paraguay",
				"Peru",
				"Philippines",
				"Pitcairn",
				"Poland",
				"Portugal",
				"Puerto Rico",
				"Qatar",
				"Reunion",
				"Romania",
				"Russian Federation",
				"Rwanda",
				"Saint Kitts and Nevis",
				"Saint Lucia",
				"Saint Vincent and the Grenadines",
				"Samoa",
				"San Marino",
				"Sao Tome and Principe",
				"Saudi Arabia",
				"Senegal",
				"Seychelles",
				"Sierra Leone",
				"Singapore",
				"Slovakia (Slovak Republic)",
				"Slovenia",
				"Solomon Islands",
				"Somalia",
				"South Africa",
				"South Georgia and the South Sandwich Islands",
				"Spain",
				"Sri Lanka",
				"St. Helena",
				"St. Pierre and Miquelon",
				"Sudan",
				"Suriname",
				"Svalbard and Jan Mayen Islands",
				"Swaziland",
				"Sweden",
				"Switzerland",
				"Syrian Arab Republic",
				"Taiwan, Province of China",
				"Tajikistan",
				"Tanzania, United Republic of",
				"Thailand",
				"Togo",
				"Tokelau",
				"Tonga",
				"Trinidad and Tobago",
				"Tunisia",
				"Turkey",
				"Turkmenistan",
				"Turks and Caicos Islands",
				"Tuvalu",
				"Uganda",
				"Ukraine",
				"United Arab Emirates",
				"United Kingdom",
				"United States",
				"United States Minor Outlying Islands",
				"Uruguay",
				"Uzbekistan",
				"Vanuatu",
				"Venezuela",
				"Vietnam",
				"Virgin Islands (British)",
				"Virgin Islands (U.S.)",
				"Wallis and Futuna Islands",
				"Western Sahara",
				"Yemen",
				"Yugoslavia",
				"Zambia",
				"Zimbabwe"
		);
		foreach($countries as $item) {
				$lists[$item] = $item;
		}
		return $lists;
}
ossn_register_callback('ossn', 'init', 'events_init');