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
 class Login {
	 	/**
		 * aouth initilize
		 * 
		 * @return object
		 */
	    public function aouth(){
			return social_login_cred();
		}
	 	/**
		 * Initilize Facebook
		 * 
		 * @return object
		 */		
		public function initFb(){
				$oauth = $this->aouth()->facebook;
				require_once(SOCIAL_LOGIN . 'vendors/Facebook/autoload.php');
				$fb = new Facebook\Facebook(array(
						'app_id' => $oauth->consumer_key,
						'app_secret' => $oauth->consumer_secret,
						'default_graph_version' => 'v2.5'
				));	
				return $fb;
		}
	 	/**
		 * Get a facebook login URL
		 * 
		 * @return string
		 */		
		public function fbURL(){
				$helper = $this->initFb()->getRedirectLoginHelper();
				$url    = $helper->getLoginUrl(ossn_site_url("social_login/facebook"), array(
						'email',
				));
				return $url;			
		}
	 
 }