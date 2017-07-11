<?php
/**
* 
*/
class Product extends OssnObject
{
	public function get($owner_guid)
	{
		$this->owner_guid = $owner_guid;
		$this->type       = 'user';
		$this->subtype    = 'market';
		$this->order_by   = 'guid DESC';
		return $this->getObjectByOwner();
	}

	public function initAttributes() 
	{
		if(empty($this->type)) {
			$this->type = 'user';
		}
		$this->OssnFile = new OssnFile;
		if(!isset($this->data)) {
			$this->data = new stdClass;
		}
		$this->OssnDatabase = new OssnDatabase;
	}
	
	public function post($data) 
	{
		self::initAttributes();
		$access = $data['privacy'];
		$post = $data['post'];
		$friends = $data['friends'];
		$location = $data['location'];

		if(empty($access)) {
			$access = OSSN_PUBLIC;
		}
		$canpost = false;
		if(!empty($post)) {
			$canpost = true;
		}
		if(!empty($_FILES['ossn_photo']['tmp_name'])) {
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
		$this->subtype           = 'market';
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
		$wallpost['name'] = $data['product']['name'];
				//Encode multibyte Unicode characters literally (default is to escape as \uXXXX)
		$this->description = json_encode($wallpost, JSON_UNESCAPED_UNICODE);
		
		if($this->addObject()) {
			$this->wallguid = $this->getObjectId();
			if(isset($_FILES['ossn_photo'])) {
				$this->OssnFile->owner_guid = $this->wallguid;
				$this->OssnFile->type       = 'object';
				$this->OssnFile->subtype    = 'wallphoto';
				$this->OssnFile->setFile('ossn_photo');
				$this->OssnFile->setPath('ossnwall/images/');
				$this->OssnFile->setExtension(array(
					'jpg',
					'png',
					'jpeg',
					'gif'
					));
				$this->OssnFile->addFile();
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

	public function setPrice($price)
	{
		if( $price == $this->getPrice() ) { 
			return $this; 
		}
	}

	public function getPrice()
	{
		if(isset($this->price)) {
			return (int) $this->price;
		}
		return null;
	}

	public function GetPost($guid) {
		$this->object_guid = $guid;
		return $this->getObjectById();
	}
}