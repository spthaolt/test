<?php
/**
 *  Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
class SOFTLAB24_API {
		//End Points
		private $Endpoint = 'https://api.softlab24.com/api/';
		
		//Factory Version
		private $Version = 'v1';
		
		/**
		 * Initilize 
		 *
		 * @param array $options The options you want to broadcast
		 * @return void
		 */
		public function __construct(array $options = array()) {
				$this->options = $options;
		}
		/**
		 * Factory methods List 
		 *
		 * @return array
		 */		
		private static function Methods() {
				return array(
						'sentiment' => '/sentiment.py',
				);
		}
		/**
		 * Prepare Call
		 *
		 * @param array $vars The options you want to broadcast
		 * @return boolean|string
		 */		
		private function prepareCall(array $vars = array()) {
				if(empty($this->Endpoint) || empty($this->Version) || empty($vars['method'])){
					return false;
				}
				return $this->Endpoint . $this->Version . $vars['method'];
		}
		/**
		 * Call
		 *
		 * @param string $method The mehtod you want to call
		 * @return string
		 */			
		private function Call($method = '') {
				$methods = self::Methods();
				if(!isset($methods[$method]) || empty($methods[$method])) {
						return false;
				}
				$vars           = array();
				$vars['method'] = $methods[$method];
				$endpoint       = $this->prepareCall($vars);
				return $this->handShake($endpoint, $this->options);
		}
		/**
		 * Hand Shake
		 *
		 * @param string $endpoint The complete URL for endpoint
		 * @param array $options The options you want to broadcast
		 * 
		 * @return boolean|string
		 */					
		private function handShake($endpoint, array $options = array()) {
				if(empty($endpoint) || empty($options)) {
						return false;
				}
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $endpoint);
				curl_setopt($curl, CURLOPT_CAINFO, SOFTLAB24 . 'vendors/cacert.pem');
				curl_setopt($curl, CURLOPT_POST, sizeof($options));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $options);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($curl);
				curl_close($curl);
				return $result;
		}
		/**
		 * Get
		 *
		 * Reading data from inaccessible properties.
		 *
		 * @param string $option A object
		 * 
		 * @return boolean|string
		 */				
		public function __get($option) {
				return $this->Call($option);
		}
}		