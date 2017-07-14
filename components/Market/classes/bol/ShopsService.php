<?php
namespace Market\bol;

class ShopsService extends \OssnObject
{
	public function requestShop($params)
	{
		if (isset($params['shop_guid']) && !empty($params['shop_guid'])) {
			$this->object_guid = trim($params['shop_guid']);
			$this->guid = trim($params['shop_guid']);
			$this->title = $this->getObjectById()->title;
		}
		if (isset($params['shop_name'])) $this->title = trim($params['shop_name']);
		
		$this->description = null;
		$this->type       = 'user';
		$this->subtype    = 'market:shop';
		$this->owner_guid = $params['owner_guid'];


		if($params['privacy'] == OSSN_PRIVATE || $params['privacy'] == OSSN_PUBLIC) {

			if (isset($params['shop_url'])) $this->data->friendly_url = $params['shop_url'];
			if (isset($params['privacy'])) $this->data->membership = $params['privacy'];
			if (isset($params['shop_fullname'])) $this->data->fullname = $params['shop_fullname'];
			if (isset($params['shop_phone'])) $this->data->phone = $params['shop_phone'];
			if (isset($params['shop_sid'])) $this->data->sid = $params['shop_sid'];
				
			$this->data->approved = null;
			$this->data->sid_image = null;
			$this->data->lock = 1;
		}
		if($this->save()) {
			return true;
		}
		return false;
	}

	public function getByOwnerGUID($owner_guid)
	{
		$this->owner_guid = $owner_guid;
		$this->type       = 'user';
		$this->subtype    = 'market:shop';
		return $this->getObjectByOwner();
	}

	// get all shop
	public function getAllShop()
	{
		$this->type       = 'user';
		$this->subtype    = 'market:shop';
		return $this->getObjectByOwner();
	}


}

