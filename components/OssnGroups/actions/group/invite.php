<?php


$friends = input('friend');
$groupId = input('group');
$invitationName = input('invitationName');

if ($friends) {

	$add = new OssnGroup;
	$errors = array();

	// add group
	foreach ($friends as $value) {

		if (!$add->sendRequestInvite($value, $groupId))
			array_push($errors, $value);    
	}

	//add invitation
	


	// check error
	if (sizeof($errors) > 0)  {
		foreach ($errors as $val)
			ossn_trigger_message(ossn_print('group:invite:error', array(ossn_user_by_guid($val)->fullname)), 'error');
	} else 
		ossn_trigger_message(ossn_print('group:invite:success'), 'success');

} else
	ossn_trigger_message(ossn_print('group:invite:save:null'), 'error');

redirect(REF);
