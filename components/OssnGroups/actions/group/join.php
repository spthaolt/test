<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$add = new OssnGroup;
$group = input('group');

if (empty($group)) {
    ossn_trigger_message(ossn_print('member:add:error'), 'error');
    redirect(REF);
}

// get info group
$infoGroup = ossn_get_group_by_guid($group);

//check membership or invite group
if($infoGroup->groupMembership == MEMBERSHIP_OPEN || $add->inviteExists(ossn_loggedin_user()->guid, $group)) {

	if ($add->approveInvite(ossn_loggedin_user()->guid, $group)) {
	    ossn_trigger_message(ossn_print('group:invite:accept:succes'), 'success');
    	redirect(ossn_group_url($group));
	} else ossn_trigger_message(ossn_print('group:invite:accept:fail'), 'error');

} elseif ($infoGroup->groupMembership == MEMBERSHIP_INVITE_ONLY) {

	ossn_trigger_message(ossn_print('group:invite:accept:fail'), 'error');
} else {

	if ($add->sendRequest(ossn_loggedin_user()->guid, $group)) {
	    ossn_trigger_message(ossn_print('memebership:sent'), 'success');
    	redirect(ossn_group_url($group));
	} else ossn_trigger_message(ossn_print('memebership:sent:fail'), 'error');
}

redirect(REF);
