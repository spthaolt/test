<?php

$add = new OssnGroup;
$group = input('group');
$user = input('user');

// get info group
$groupInfo = ossn_get_group_by_guid($group);

if (!$groupInfo) {
    ossn_trigger_message(ossn_print('group:not:exist'), 'error');
    redirect(REF);
}

//check membership or invite group
if($infoGroup->membship == Membership_Open || $add->inviteExists($user, $group)) {

	if ($add->acceptInvite(ossn_loggedin_user()->guid, $group)) {
	    ossn_trigger_message(ossn_print('group:invite:accept:succes'), 'success');
	    redirect("group/{$group}");
	} else ossn_trigger_message(ossn_print('group:invite:accept:fail'), 'error');

} elseif ($infoGroup->membship == Membership_Invite_Only) {

	ossn_trigger_message(ossn_print('group:invite:accept:fail'), 'error');
}

redirect(REF);