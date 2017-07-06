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
class OssnGroup extends OssnObject {
		
		/**
		 * Initialize the object.
		 *
		 * @return void;
		 */
		public function initAttributes() {
				$this->OssnDatabase = new OssnDatabase;
				$this->OssnFile     = new OssnFile;
		}
		
		/**
		 * Create group
		 *
		 * @params $params['name'] Name of group
		 *         $params['description'] Group description
		 *         $params['owner_guid']: Guid of owner creating group
		 *         $params['privacy'] Group Privacy
		 *
		 * @return bool;
		 */
		public function createGroup($params) {
				self::initAttributes();
				$this->title       = trim($params['name']);
				$this->description = trim($params['description']);
				if(empty($this->title)) {
						return false;
				}
				$this->owner_guid = $params['owner_guid'];
				$this->type       = 'user';
				$this->subtype    = 'ossngroup';
				if($params['privacy'] == OSSN_PRIVATE || $params['privacy'] == OSSN_PUBLIC) {
						$this->data->membership = $params['privacy'];
				}
				if($this->addObject()) {
						ossn_add_relation($params['owner_guid'], $this->getGuid(), 'group:join');
						ossn_add_relation($this->getGuid(), $params['owner_guid'], 'group:join:approve');
						return true;
				}
				return false;
		}
		
		/**
		 * Get guid of newly created group
		 *
		 * @return int;
		 * @access public;
		 */
		public function getGuid() {
				return $this->getObjectId();
		}
		
		/**
		 * Get User groups
		 *
		 * @params $owner_guid Guid of owner creating group
		 *
		 * @return object;
		 */
		public function getUserGroups($owner_guid) {
				$this->owner_guid = $owner_guid;
				$this->type       = 'user';
				$this->subtype    = 'ossngroup';
				return $this->getObjectByOwner();
		}
		
		/**
		 * Get site group
		 *
		 * @return object;
		 */
		public function getGroups() {
				$this->type    = 'user';
				//fixes #154
				$this->subtype = 'ossngroup';
				return $this->getObjectsByTypes();
		}
		
		/**
		 * Get group by guid
		 *
		 * @params $guid group guid
		 *
		 * @return object;
		 */
		public function getGroup($guid) {
				$this->object_guid = $guid;
				$group             = $this->getObjectById();
				if($group->subtype == 'ossngroup') {
						return $group;
				}
				return false;
		}
		
		/**
		 * Upgrade group
		 *
		 * @params $name Group name
		 *         $description Group description
		 *         $guid Group guid
		 *
		 * @return bool;
		 */
		public function updateGroup($name, $description, $guid) {
				$data   = array(
						'title',
						'description'
				);
				$values = array(
						$name,
						$description
				);
				if($this->updateObject($data, $values, $guid)) {
						return true;
				}
				return false;
		}
		
		/**
		 * Delete group
		 *
		 * @params $guid Group guid
		 *
		 * @return bool;
		 */
		public function deleteGroup($guid) {
				if(empty($guid)) {
						return false;
				}
				$vars['entity'] = ossn_get_group_by_guid($guid);
				if($this->deleteObject($guid)) {
						//delete group relations
						ossn_delete_group_relations($vars['entity']);
						//trigger callback so other components can be notified when group is deleted.
						ossn_trigger_callback('group', 'delete', $vars);
						return true;
				}
				return false;
		}
		
		/**
		 * Count member requests
		 *
		 * @return int;
		 */
		public function countRequests() {
				$count = $this->getMembersRequests();
				if(!$count) {
						return false;
				}
				$cc = 0;
				foreach($count as $c) {
						$cc++;
				}
				return $cc;
		}
		
		/**
		 * Get group member requests
		 *
		 * @params $object->guid Group guid
		 *
		 * @return object;
		 */
		public function getMembersRequests() {
				$group = $this->guid;
				$this->statement("SELECT * FROM ossn_relationships WHERE(
					     relation_to='{$group}' AND
					     type='group:join'
					     );");
				$this->execute();
				$from = $this->fetch(true);
				if(!is_object($from)) {
						return false;
				}
				foreach($from as $fr) {
						if(!$this->isMember($group, $fr->relation_from)) {
								$users[] = ossn_user_by_guid($fr->relation_from);
						}
				}
				if(isset($users)) {
						return $users;
				}
				return false;
		}
		
		/**
		 * Get Invites To Groups
		 *
		 * @params $userId user guid
		 *
		 * @return object;
		 */
		public function getInvitesToGroups($userId) {
			if(empty($userId)) {
				return false;
			}

			// get invite all 
			$invites = group_get_invites_user($userId, 'group:invite');

			// check null
			if ($invites) {

				// check member group and get group info	
				foreach($invites as $invite) {
					if(!$this->isMember($invite->relation_to, $invite->relation_from)) {
						$groups[] = $this->getGroup($invite->relation_to);
					}
				}

				if(isset($groups)) {
					return $groups;
				}
			} 
			return false;
		}
		
		/**
		 * Check if the user is memeber of group or not
		 *
		 * @params $user User guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function isMember($group, $user) {
			if(isset($this->guid)) {
					$group = $this->guid;
			}

			$joinApprove = group_check_exits_relation($group, $user,"group:join:approve");
			$join = group_check_exits_relation($user, $group,"group:join");

			$inviteApprove = group_check_exits_relation($group, $user,"group:invite:approve");
			$invite = group_check_exits_relation($user, $group,"group:invite");

			if ($joinApprove && $join) 
				return true;
			else if ($inviteApprove && $invite) 
				return true;
			
			return false;
		}
		
		/**
		 * Get group members
		 *
		 * @params $object->guid Group guid
		 *
		 * @return object;
		 */
		public function getMembers($count = false) {
			if (!isset($this->guid)) {
				return false;
			}

			$members = ossn_get_relationships(array(
					'from' => $this->guid,
					'type' => array('group:join:approve', 'group:invite:approve'),
					'count' => $count,
			));

			if ($count) {
				return $members;
			}
			foreach ($members as $member) {
					$users[] = ossn_user_by_guid($member->relation_to);
			}
			if (isset($users)) {
					return $users;
			}
			return false;
		}
		
		/**
		 * Send group join request
		 *
		 * @params $from Member guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function sendRequest($from, $group) {
				self::initAttributes();
				if(!$this->requestExists($from, $group)) {
						if(ossn_add_relation($from, $group, 'group:join')) {
								// #186 send notification to Group Owner
								$current_group = $this->getGroup($group);
								$group_owner   = $current_group->owner_guid;
								
								$type             = 'group:joinrequest';
								$params['into']   = 'ossn_notifications';
								$params['names']  = array(
										'type',
										'poster_guid',
										'owner_guid',
										'subject_guid',
										'item_guid',
										'time_created'
								);
								$params['values'] = array(
										$type,
										$from,
										$group_owner,
										$group,
										0,
										time()
								);
								if($this->OssnDatabase->insert($params)) {
										return true;
								}
						}
				}
				return false;
		}

		/**
		 * Send group join request
		 *
		 * @params 
		 *         $group Group guid
		 *		   $receiver Member guid
		 *
		 * @return bool;
		 */
		public function sendRequestInvite($receiver, $groupId ) {
			self::initAttributes();

			$user = ossn_loggedin_user();
			if (!$user) return false;

			if ($this->requestExists($receiver, $groupId)) {

				if (ossn_delete_group_request($receiver, $groupId, 'group:join')) 
					if ($this->approveInvite($receiver, $groupId)) return true;
				
			} else if (!$this->inviteExists($receiver, $groupId)) {

				if (ossn_add_relation($receiver, $groupId, 'group:invite')) {

					$notification = new OssnNotifications();
					$type = 'group:inviterequest';
					return $notification->addNotification($type, $user->guid, $receiver ,$groupId , 0);
				}
			}
		
			return false;
		}

		/**
		 * approve Invite
		 *
		 * @params $receiver Member guid
		 *         $groupId Group guid
		 *
		 * @return bool;
		 */
		public function approveInvite($receiver, $groupId ) {
			self::initAttributes();

			if ((ossn_add_relation($receiver, $groupId, 'group:invite')) && 
				(ossn_add_relation($groupId, $receiver, 'group:invite:approve'))) {
					return true;
			}

			return false;
		}

		/**
		 * acceptInvite
		 *
		 * @params $receiver Member guid
		 *         $groupId Group guid
		 *
		 * @return bool;
		 */
		public function acceptInvite($receiver, $groupId ) {
			self::initAttributes();

			if($this->inviteExists($receiver, $groupId)) {
				if(ossn_add_relation($groupId, $receiver, 'group:invite:approve')) {
						return true;
				}
			}
			return false;
		}

		/**
		 * reject Invite
		 *
		 * @params $receiver Member guid
		 *         $groupId Group guid
		 *
		 * @return bool;
		 */
		public function rejectInvite($receiver, $groupId ) {

			if($this->inviteExists($receiver, $groupId)) {
				if(ossn_delete_group_request($receiver, $groupId, 'group:invite')) {
						return true;
				}
			}
			return false;
		}

		/**
		 * Check if member request exist or not
		 *
		 * @params $from Member guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function requestExists($from, $group) {
			if(isset($this->guid)) {
				$group = $this->guid;
			}
			return ossn_relation_exists($from, $group, 'group:join');
		}

		/**
		 * Check if member request exist or not
		 *
		 * @params $from Member guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function inviteExists($from, $group) {
			if(isset($this->guid)) {
				$group = $this->guid;
			}
			return ossn_relation_exists($from, $group, 'group:invite');
		}
		
		/**
		 * Approve member request
		 *
		 * @params $from Member guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function approveRequest($from, $group) {
				if($this->requestExists($from, $group)) {
						if(ossn_add_relation($group, $from, 'group:join:approve')) {
								return true;
						}
				}
				return false;
		}
		
		/**
		 * Delete member from group
		 *
		 * @params $from Member guid
		 *         $group Group guid
		 *
		 * @return bool;
		 */
		public function deleteMember($receiver, $group) {

			if (!$this->requestExists($receiver, $group) && 
				!$this->inviteExists($receiver, $group)) {
				return false;
			}

			if (group_delete_join_or_invite($receiver, $group)) 
				return true;
		
			return false;
		}
		
		/**
		 * Search group in database
		 *
		 * @params $q Group Metadata
		 *
		 * @return object;
		 */
		public function searchGroups($q) {
				$params['from']   = 'ossn_object';
				$params['wheres'] = array(
						"(title LIKE '%{$q}%' OR description LIKE '%{$q}%') AND
		                           type='user' AND subtype='ossngroup'"
				);
				$search           = $this->select($params, true);
				if(!$search) {
						return false;
				}
				foreach($search as $group) {
						$groupentity[] = ossn_get_group_by_guid($group->guid);
				}
				$data = $groupentity;
				return $data;
		}
		
		/**
		 * Upload group photo
		 *
		 * @return boolean|null
		 * @access public;
		 */
		public function uploadPhoto() {
			self::initAttributes();
			if(empty($this->guid) || $this->guid < 1) {
				return false;
			}

			$this->OssnFile->owner_guid = $this->guid;
			$this->OssnFile->type       = 'object';
			$this->OssnFile->subtype    = 'avatar';
			$this->OssnFile->setFile('userphoto');
			$this->OssnFile->setExtension(array(
					'jpg',
					'png',
					'jpeg',
					'gif'
			));
			$this->OssnFile->setPath('avatar/');
			$files = clone $this->OssnFile;
			if($this->OssnFile->addFile()) {
	
					$files = $files->getFiles();
					$count = (array) $files;
					if(count($count) > 1) {
							unset($files->{0});
							if($files) {
									foreach($files as $file) {
											$file->deleteEntity();
									}
							}
					}
					// $this->ResetCoverPostition($this->OssnFile->owner_guid);
					return true;
			}
		}

		/**
		 * Get group latest avatar url
		 *
		 * @return url;
		 * @access public;
		 */
		public function avatarURL($size = null) {
				self::initAttributes();
				if(empty($this->guid) || $this->guid < 1) {
						return false;
				}

				$this->OssnFile->owner_guid = $this->guid;
				$this->OssnFile->type       = 'object';
				$this->OssnFile->subtype    = 'avatar';
				$avatars = $this->OssnFile->getFiles();

				if(!$avatars) 
					return ossn_site_url("groups/avatar/{$size}/".md5($this->title).'.jpg');
				
				$this->latestcover = $avatars->getParam(0);
				$file  = str_replace('avatar/', '', $this->latestcover->value);

				if (!is_null($size)) 
					$this->avatarurl = ossn_site_url("groups/avatar/{$this->latestcover->guid}/{$size}_{$file}");
				else 
					$this->avatarurl = ossn_site_url("groups/avatar/{$this->latestcover->guid}/{$file}");
				
				return ossn_call_hook('group', 'cover:url', $this, $this->avatarurl);
		}

		/**
		 * Upload group cover
		 *
		 * @return boolean|null
		 * @access public;
		 */
		public function UploadCover() {
				self::initAttributes();
				if(empty($this->guid) || $this->guid < 1) {
						return false;
				}
				$this->OssnFile->owner_guid = $this->guid;
				$this->OssnFile->type       = 'object';
				$this->OssnFile->subtype    = 'cover';
				$this->OssnFile->setFile('coverphoto');
				$this->OssnFile->setExtension(array(
						'jpg',
						'png',
						'jpeg',
						'gif'
				));
				$this->OssnFile->setPath('cover/');
				$files = clone $this->OssnFile;
				if($this->OssnFile->addFile()) {
						//Different sanity checks on uploading images? #667
						$files = $files->getFiles();
						$count = (array) $files;
						if(count($count) > 1) {
								unset($files->{0});
								if($files) {
										foreach($files as $file) {
												$file->deleteEntity();
										}
								}
						}
						$this->ResetCoverPostition($this->OssnFile->owner_guid);
						return true;
				}
		}
		
		/**
		 * Reset cover position
		 *
		 * @param $guid Group guid
		 *
		 * @return bool;
		 * @access private;
		 */
		public function ResetCoverPostition($guid) {
				$this->statement("SELECT * FROM ossn_entities WHERE(
				             owner_guid='{$guid}' AND
				             type='object' AND
				             subtype='cover');");
				$this->execute();
				$entity   = $this->fetch();
				$position = array(
						'',
						''
				);
				
				$fields           = new OssnEntities;
				$fields->owner_id = $guid;
				$fields->guid     = $entity->guid;
				$fields->type     = 'user';
				
				$fields->subtype = 'cover';
				$fields->value   = json_encode($position);
				if($fields->updateEntity()) {
						return true;
				}
				return false;
		}
		
		/**
		 * Check if group have cover or not
		 *
		 * @return bool;
		 * @access private;
		 */
		public function haveCover() {
				$covers = $this->groupCovers();
				if(isset($covers->{0})) {
						return true;
				}
				return false;
		}
		
		/**
		 * Get group covers
		 *
		 * @return object;
		 * @access public;
		 */
		public function groupCovers() {
				self::initAttributes();
				if(empty($this->guid) || $this->guid < 1) {
						return false;
				}
				$this->OssnFile->owner_guid = $this->guid;
				$this->OssnFile->type       = 'object';
				$this->OssnFile->subtype    = 'cover';
				return $this->OssnFile->getFiles();
		}
		
		/**
		 * Get group latest cover url
		 *
		 * @return url;
		 * @access public;
		 */
		public function coverURL() {
				$covers = $this->groupCovers();
				if(!$covers) {
						return false;
				}
				$this->latestcover = $covers->getParam(0);
				$file              = str_replace('cover/', '', $this->latestcover->value);
				$this->coverurl    = ossn_site_url("groups/cover/{$this->latestcover->guid}/{$file}");
				return ossn_call_hook('group', 'cover:url', $this, $this->coverurl);
		}
		
		/**
		 * Reposition group cover
		 *
		 * @param $guid Group guid
		 *        $top  Position from top
		 *        $left Position from left
		 *
		 * @return bool;
		 * @access public;
		 */
		public function repositionCOVER($guid, $top, $left) {
				$user = ossn_get_group_by_guid($guid);
				if(!isset($user->cover) && empty($user->cover)) {
						$position           = array(
								$top,
								$left
						);
						$fields             = new OssnEntities;
						$fields->owner_guid = $guid;
						$fields->type       = 'object';
						$fields->subtype    = 'cover';
						$fields->value      = json_encode($position);
						if($fields->add()) {
								return true;
						}
				} else {
						$this->statement("SELECT * FROM ossn_entities WHERE(
				             owner_guid='{$guid}' AND
				             type='object' AND
				             subtype='cover');");
						$this->execute();
						$entity    = $this->fetch();
						$entity_id = $entity->guid;
						
						$position         = array(
								$top,
								$left
						);
						$fields           = new OssnEntities;
						$fields->owner_id = $guid;
						$fields->guid     = $entity_id;
						$fields->type     = 'object';
						
						$fields->subtype = 'cover';
						$fields->value   = json_encode($position);
						if($fields->updateEntity()) {
								return true;
						}
				}
				return false;
		}
		
		/**
		 * Get cover position params
		 *
		 * @param int $guid Group guid
		 *
		 * @return array;
		 * @access public;
		 */
		public function coverParameters($guid) {
				$parameters = ossn_get_group_by_guid($guid)->cover;
				return json_decode($parameters);
		}
		/**
		 * Get user groups (owned groups and groups user member of)
		 * 
		 * @param object $user User entity
		 * @return array
		 */
		public function getMyGroups($user) {
				self::initAttributes();
				if(empty($user->guid) || !$user instanceof OssnUser) {
						return false;
				}
				$params           = array();
				$params['from']   = "ossn_relationships";
				$params['wheres'] = array(
						"relation_from='{$user->guid}'",
						"AND type='group:join'"
				);
				# zfix #177 old code throws PHP warnings if user is not member of any group	
				if($myGroups = $this->OssnDatabase->select($params, true)) {
						$myGroups = $this->OssnDatabase->select($params, true);
						$myGroups = get_object_vars($myGroups);
						foreach($myGroups as $group) {
								$group = $this->getGroup($group->relation_to);
								if($this->isMember($group->guid, $user->guid)) {
										$groupsEntities[] = arrayObject($group, get_class($this));
								}
						}
						if(!empty($groupsEntities)) {
								return $groupsEntities;
						}
				}
				return false;
		}
} //class
