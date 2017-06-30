<a href="/messages/group/<?php echo $params->guid ?>" class="list-group-item <?php echo $params->is_active ?>" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="<?php echo $params->avatarURL("smaller") ?>" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px"><?php echo $params->title ?></p>
	</div>
	<div class="clearfix"></div>
</a>