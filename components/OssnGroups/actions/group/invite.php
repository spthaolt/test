<?php


$friends = input('friend');
$groupId = input('group');

if ($friends) {

	$add = new OssnGroup;
	$groupInfo = $add->getGroup($groupId);

	if($groupInfo) {
		
		$errors = array();
	
		// add group
		foreach ($friends as $friend) {
			if (!$add->sendRequestInvite($friend, $groupId))
				array_push($errors, $friend);    
		}

		// check error
		if (sizeof($errors) > 0)  {

			foreach ($errors as $val)
				ossn_trigger_message(ossn_print('group:invite:error', array(ossn_user_by_guid($val)->fullname)), 'error');
		} else ossn_trigger_message(ossn_print('group:invite:success'), 'success');

	} else ossn_trigger_message(ossn_print('group:not:exist'), 'error'); 

} else
	ossn_trigger_message(ossn_print('group:invite:save:null'), 'error');

redirect(REF);
