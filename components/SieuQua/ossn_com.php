<?php


function sieuqua_init() 
{
	ossn_register_callback('message', 'created', 'sieuqua_chat');
}

function sieuqua_php_connect_nodejs($data)
{
    $jsonData = json_encode($data);
    $f = fsockopen("localhost", 6000, $errno, $errstr, 30);
    fwrite($f, $jsonData);
    fclose($f);
}

function sieuqua_chat($hook, $type, $bool, $params) 
{
	$message = input('message');
	$to = input('to');
	$from = ossn_loggedin_user()->guid;
	$contentsChat = [
        'action' => "post_message",
        'from' => ossn_user_by_guid($from)->username,
        'to' => ossn_user_by_guid($to)->username,
        'text' => $message,
        'time' => round(microtime(true) * 1000)
    ];
    sieuqua_php_connect_nodejs($contentsChat);
}


ossn_register_callback('ossn', 'init', 'sieuqua_init');