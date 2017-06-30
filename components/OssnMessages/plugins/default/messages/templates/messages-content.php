<div class="message-inner sqmessage" >
	<div class="message-with">
		<div class="message-inner" id="message-append-<?php echo $params['to_guid'] ?>">
			<?php echo $params['messages_content'] ?>
		</div>
	</div>
</div>
<?php 
	echo ossn_view_form('send', array(
			'component' => 'OssnMessages',
			'class' => 'message-form-form sqmessage',
			'id' => "message-send-{$params['to_guid']}",
			'params' => $params
	), false);
?>