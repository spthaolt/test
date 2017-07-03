<div class="thumbnail sqmessage">
	<div class="col-sm-3 sqmessage">
		<div class="list-group sqmessage">
			<?php echo $params['groups_list'] ?>
		</div>
	</div>
	<div class="col-sm-6 sqmessage">
		<?php echo $params['messages_body'] ?>
	</div>
	<div class="col-sm-3 sqmessage">
		<div class="statusfriends list-group sqmessage">
			<?php echo $params['friends_list'] ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<audio id="ossn-chat-sound" src="<?php echo ossn_site_url("components/OssnMessages/sound/pling.mp3"); ?>" preload="auto"></audio>
<?php echo $params['script']; ?>