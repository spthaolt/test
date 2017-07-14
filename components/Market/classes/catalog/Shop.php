<?php
namespace Market\catalog;

class Shop extends \OssnObject
{
	public function requestShop($params)
	{
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
		if($this->addObject()) {
			return true;
		}
		return false;
	}

	public function updateShop($params)
	{
		if ($params['shop_name']) {
			$this->updateObject(array('title'), array($params['shop_name']), $params['owner_guid']);
		}

		$this->owner_guid = $params['owner_guid'];
		$this->type = 'object';
		foreach ($params['subtypes'] as $key => $value) {
			$this->subtype = $key;
	        $entity = $this->get_entities();
	        $this->guid = $entity[0]->guid;
	        $this->value = $value;
	        $this->updateEntity();
		}
		if ($params['owner_guid']) {
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

