<?php
/**
*
*/
$type = input('type');
if(empty($type)){
	$type = 'pending';
}

echo ossn_plugin_view("market/layout/administrator", array( 'type' => $type ));