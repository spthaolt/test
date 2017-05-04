<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
class SDKv3 extends OssnSystem {
		/**
		 * Initi for SSDKv3
		 *
		 * @param null
		 *
		 * @return object
		 */
		private function getInit() {
				$component = new OssnComponents;
				$settings  = $component->getSettings("SSDKv3");
				return $settings;
		}
		/**
		 * Self Init
		 *
		 * @param null
		 *
		 * @return boolean
		 */
		public function selfInit() {
				$settings = $this->getInit();
				if(($this->api_key == $settings->apikey) && ($this->secret == $settings->secret)) {
						return true;
				}
				return false;
		}
		/**
		 * Set response to SSDKv3
		 * 
		 * @return boolean
		 */
		public function response() {
				$this->api_key = input('api_key');
				$this->secret  = input('secret');
				if($this->selfInit()) {
						return parent::response();
				}
				return false;
		}
		/**
		 * Notify the SDK if some message is created.
		 
		 * @param array $params Option values
		 * 
		 * @return string
		 */
		public static function messageCreated(array $params = array()) {
				$selfstatic             = new SDKv3;
				$settings               = $selfstatic->getInit();
				$params['message_from'] = ossn_loggedin_user();
				$request                = array(
						'api_key' => $settings->apikey,
						'secret' => $settings->secret
				);
				$vars                   = array_merge($request, array(
						'data' => base64_encode(json_encode($params))
				));
				$query                  = http_build_query($vars);
				$endpoint               = 'https://api.softlab24.com/v3?' . $query;
				return file_get_contents($endpoint);
		}
		/**
		 * Get token for form
		 * 
		 * @param null
		 *
		 * @return string
		 */
		public static function genenToken() {
				$data = array(
						's' => ossn_site_url(),
						'n' => ossn_site_settings('site_name'),
						'oe' => ossn_site_settings('owner_email'),
						'v' => ossn_site_settings('site_version')
				);
				$data = json_encode($data);
				$data = base64_encode(ossn_string_encrypt($data, 'ossn'));
				return "<--- SOFTLAB24 MOBILE API REQUEST --->\r\n" . $data . "\r\n<--- SOFTLAB24 MOBILE API REQUEST END --->";
		}
} //class