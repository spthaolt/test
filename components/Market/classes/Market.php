<?php

class Market extends OssnObject {

	public function get($owner_guid)
	{
		$this->owner_guid = $owner_guid;
		$this->type       = 'user';
		$this->subtype    = 'market';
		return $this->getObjectByOwner();
	}
}