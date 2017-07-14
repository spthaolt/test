<?php
namespace Market\catalog;

class Shop extends \OssnObject
{
	public function requestShop($params)
	{
		$this->guid 	= $params['shop_guid'];
		$this->title       = trim($params['shop_name']);
		if(empty($this->title)) {
			return false;
		}
		$this->owner_guid = $params['owner_guid'];
		$this->type       = 'user';
		$this->subtype    = 'market:shop';
		if($params['privacy'] == OSSN_PRIVATE || $params['privacy'] == OSSN_PUBLIC) {
				$this->data->friendly_url = $params['shop_url'];
				$this->data->membership = $params['privacy'];
				$this->data->approved = null;
				$this->data->fullname = $params['fullname'];
				$this->data->phone = $params['phone'];
				$this->data->sid = $params['sid'];
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


}

