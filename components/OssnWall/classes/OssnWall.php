<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
class OssnWall extends OssnObject {
		/**
		 * Post on wall
		 *
		 * @params $post: Post text
		 *         $friends: Friend guids
		 *         $location: Post location
		 *         $access: (OSSN_PUBLIC, OSSN_PRIVATE, OSSN_FRIENDS)
		 * @param string $post
		 *
		 * @return bool;
		 */
		public function Post($post, $friends = '', $location = '', $access = '', $ossn_photo = '') {
				self::initAttributes();

				if(empty($access)) {
					$access = OSSN_PUBLIC;
				}
				$canpost = false;
				if(!empty($post)) {
					$canpost = true;
				}
				if(sizeof($ossn_photo) > 0 && $ossn_photo) {
					$canpost = true;
				}
				if(empty($this->owner_guid) || empty($this->poster_guid) || $canpost === false) {
					return false;
				}
				if(isset($this->item_type) && !empty($this->item_type)) {
					$this->data->item_type = $this->item_type;
				}
				if(isset($this->item_guid) && !empty($this->item_guid)) {
					$this->data->item_guid = $this->item_guid;
				}
				$this->data->poster_guid = $this->poster_guid;
				$this->data->access      = $access;
				$this->subtype           = 'wall';
				$this->title             = '';
				
				$post             = preg_replace('/\t/', ' ', $post);
				$wallpost['post'] = htmlspecialchars($post, ENT_QUOTES, 'UTF-8');
				
				//wall tag a friend , GUID issue #566
				if(!empty($friends)) {
					$friend_guids = explode(',', $friends);
					//reset friends guids
					$friends      = array();
					foreach($friend_guids as $guid) {
							if(ossn_user_by_guid($guid)) {
									$friends[] = $guid;
							}
					}
					$wallpost['friend'] = implode(',', $friends);
				}
				if(!empty($location)) {
					$wallpost['location'] = $location;
				}
				//Encode multibyte Unicode characters literally (default is to escape as \uXXXX)
				$this->description = json_encode($wallpost, JSON_UNESCAPED_UNICODE);
				if($this->addObject()) {
						// get wallguid
						$this->wallguid = $this->getObjectId();

						// get size
						$sizes = ossn_user_image_sizes();

						foreach ($ossn_photo as $photo) {

							if (!empty($photo) && !is_null($photo)) {

								$oldDir = ossn_get_userdata("files/{$photo}");
								$createDir = ossn_get_userdata("object/{$this->wallguid}/ossnwall/images/");

								// creeate foder
								if(!is_dir($createDir)) mkdir($createDir, 0755, true);

								//create sub photos
								foreach($sizes as $size => $params) {
									$params  = explode('x', $params);
									$width   = $params[1];
									$height  = $params[0];
									$resized = ossn_resize_image($oldDir, $width, $height, true);
									file_put_contents(ossn_get_userdata("object/{$this->wallguid}/ossnwall/images/{$size}_{$photo}"), $resized);
								}

								// move file photo 
								rename($oldDir, "{$createDir}{$photo}");

								// create entiti
								$fields = new OssnEntities;
					            $fields->owner_guid = $this->wallguid;
					            $fields->type = 'object';
					            $fields->subtype = 'file:wallphoto';
					            $fields->value = "ossnwall/images/" . $photo;
					            $fields->add();
							}
						}

						$params['object_guid'] = $this->wallguid;
						$params['poster_guid'] = $this->poster_guid;
						if(isset($wallpost['friend'])) {
								$params['friends'] = explode(',', $wallpost['friend']);
						}
						ossn_trigger_callback('wall', 'post:created', $params);
						return $this->wallguid;
				}
				return true;
		}
		
		/**
		 * Initialize the objects.
		 *
		 * @return void;
		 */
		public function initAttributes() {
				if(empty($this->type)) {
						$this->type = 'user';
				}
				$this->OssnFile = new OssnFile;
				if(!isset($this->data)) {
						$this->data = new stdClass;
				}
				$this->OssnDatabase = new OssnDatabase;
		}
		
		/**
		 * Get posts by owner
		 *
		 * @params $owner: Owner guid
		 *         $type Owner type
		 *
		 * @return object;
		 */
		public function GetPostByOwner($owner, $type = 'user', $count = false) {
				self::initAttributes();
				if(empty($owner) || empty($type)) {
						return false;
				}
				$vars = array(
						'type' => $type,
						'subtype' => array('wall','market'),
						'order_by' => 'o.guid DESC',
						'owner_guid' => $owner,
						'count' => $count
				);
				return $this->searchObject($vars);
		}
		
		/**
		 * Get user posts
		 *
		 * @params $user: User guid
		 *
		 * @return object;
		 */
		public function GetUserPosts($user, $count = false) {
				return $this->GetPostByOwner($user, 'user', $count);
		}
		
		/**
		 * Get post by guid
		 *
		 * @params $guid: Post guid
		 *
		 * @return object;
		 */
		public function GetPost($guid) {
				$this->object_guid = $guid;
				return $this->getObjectById();
		}
		
		/**
		 * Delete post
		 *
		 * @params $post: Post guid
		 *
		 * @return bool;
		 */
		public function deletePost($post) {
				if($this->deleteObject($post)) {
						ossn_trigger_callback('post', 'delete', $post);
						return true;
				}
				return false;
		}
		
		/**
		 * Delete All Posts
		 *
		 * @return void;
		 */
		public function deleteAllPosts() {
				$posts = $this->GetPosts(array(
							'page_limit' => false,							   
				));
				if(!$posts) {
						return false;
				}
				foreach($posts as $post) {
						$this->deleteObject($post->guid);
						ossn_trigger_callback('post', 'delete', $post->guid);
				}
		}
		
		/**
		 * Get all site wall posts
		 *
		 * @return object;
		 */
		public function GetPosts(array $params = array()) {
				$default = array(
						'subtype' => array('wall','market'),
						'order_by' => 'o.guid DESC'
				);
				$options = array_merge($default, $params);
				return $this->searchObject($options);
		}
		/**
		 * Get user group posts guids
		 *
		 * @param integer $userguid Guid of user
		 *
		 * @return array;
		 */
		public static function getUserGroupPostsGuids($userguid) {
				if(empty($userguid)) {
						return false;
				}
				$statement = "SELECT * FROM ossn_entities, ossn_entities_metadata WHERE(
				  ossn_entities_metadata.guid = ossn_entities.guid 
				  AND  ossn_entities.subtype='poster_guid'
				  AND type = 'object'
				  AND value = '{$userguid}'
				  );";
				$database  = new OssnDatabase;
				$database->statement($statement);
				$database->execute();
				$objects = $database->fetch(true);
				if($objects) {
						foreach($objects as $object) {
								$guids[] = $object->owner_guid;
						}
						asort($guids);
						return $guids;
				}
				return false;
		}
		/**
		 * Get user wall postings for wall mode set to Friends-Only 
		 *
		 * @param 
		 *
		 * @return array;
		 */
		public function getFriendsPosts($params = array()) {
				$user = ossn_loggedin_user();
				if(isset($user->guid) && !empty($user->guid)) {
						$friends      = $user->getFriends();
						//operator not supported for strings #999
						$friend_guids = array();
						if($friends) {
								foreach($friends as $friend) {
										$friend_guids[] = $friend->guid;
								}
						}
						// add all users posts;
						// (if user has 0 friends, show at least his own postings if wall access type = friends only)
						$friend_guids[] = $user->guid;
						$friend_guids   = implode(',', $friend_guids);
						
						$default = array(
								'type' => 'user',
								'subtype' => array('wall','market'),
								'order_by' => 'o.guid DESC',
								'entities_pairs' => array(
												array(
												  	'name' => 'access',
													'value' => true,
												  	'wheres' => "(1=1)"
												  ),
												array(
												  	'name' => 'poster_guid',
													'value' => true,
													'wheres' => "((emd0.value=2 OR emd0.value=3) AND [this].value IN({$friend_guids}))"
 											  )
								)
						);
						
						$options = array_merge($default, $params);
						return $this->searchObject($options);
				}
				return false;
		}

		/**
		 * Get user wall postings for wall mode set to All-Site-Posts 
		 *
		 * @param 
		 *
		 * @return array;
		 */
		public function getPublicPosts($params = array()) {
				$user = ossn_loggedin_user();
				if(isset($user->guid) && !empty($user->guid)) {
						$friends      = $user->getFriends();
						//operator not supported for strings #999
						$friend_guids = array();
						if($friends) {
								foreach($friends as $friend) {
										$friend_guids[] = $friend->guid;
								}
						}
						// add all users posts;
						// (if user has 0 friends, show at least his own postings if wall access type = friends only)
						$friend_guids[] = $user->guid;
						$friend_guids   = implode(',', $friend_guids);
						
						$default = array(
								'type' => 'user',
								'subtype' => array('wall','market'),
								'order_by' => 'o.guid DESC',
								'entities_pairs' => array(
												array(
												  	'name' => 'access',
													'value' => true,
												  	'wheres' => "(1=1)"
												  ),
												array(
												  	'name' => 'poster_guid',
													'value' => true,
													'wheres' => "(emd0.value=2) OR (emd0.value=3 AND [this].value IN({$friend_guids}))"
												  )
								)
						);
						
						$options = array_merge($default, $params);
						return $this->searchObject($options);
				}
				return false;
		}

		/**
		 * Get all user wall posts for admins
		 *
		 * @param 
		 *
		 * @return array;
		 */
		public function getAllPosts($params = array()) {
				$user = ossn_loggedin_user();
				if(isset($user->guid) && !empty($user->guid)) {
						$friends      = $user->getFriends();
						//operator not supported for strings #999
						$friend_guids = array();
						if($friends) {
								foreach($friends as $friend) {
										$friend_guids[] = $friend->guid;
								}
						}
						// add all users posts;
						// (if user has 0 friends, show at least his own postings if wall access type = friends only)
						$friend_guids[] = $user->guid;
						$friend_guids   = implode(',', $friend_guids);
						
						$default = array(
								'type' => 'user',
								'subtype' => array('wall','market'),
								'order_by' => 'o.guid DESC',
								'entities_pairs' => array(
												array(
												  	'name' => 'access',
													'value' => true,
												  	'wheres' => "(1=1)"
												  ),
												array(
												  	'name' => 'poster_guid',
													'value' => true,
													'wheres' => "(emd0.value=2 OR emd0.value=3)"
												  )
								)
						);
						
						$options = array_merge($default, $params);
						return $this->searchObject($options);
				}
				return false;
		}
		
} //class
