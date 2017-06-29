<?php

header('Content-Type: application/json');
$group = input('group');
$group = ossn_get_group_by_guid($group);

if(ossn_loggedin_user()->guid !== $group->owner_guid && !ossn_isAdminLoggedin()) {
	echo json_encode(array(
		'type' => 0
	));
	exit;
}

if($group->uploadPhoto()) {

	//get a all user photo files
	$resize = $group->OssnFile->getFiles();

	$datadir   = ossn_get_userdata("object/{$group->guid}/{$resize->{0}->value}");
	$file_name = str_replace('avatar/', '', $resize->{0}->value);

	//create sub photos
	$sizes = ossn_user_image_sizes();
	foreach($sizes as $size => $params) {
		$params  = explode('x', $params);
		$width   = $params[1];
		$height  = $params[0];
		$resized = ossn_resize_image($datadir, $width, $height, true);
		file_put_contents(ossn_get_userdata("object/{$group->guid}/avatar/{$size}_{$file_name}"), $resized);
	}

	echo json_encode(array(
			'type' => 1,
			 'url' => $group->avatarURL('larger')
	));

} else {
	echo json_encode(array(
			'type' => 0
	));
}