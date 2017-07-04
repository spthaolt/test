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

if ($add->deleteMember($user, $group)) ossn_trigger_message(ossn_print('group:invite:reject:succ'), 'success');
else ossn_trigger_message(ossn_print('group:invite:reject:fail'), 'error');
    
redirect(REF);