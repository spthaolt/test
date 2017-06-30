<a href="/messages/individual/<?php echo $params->username ?>" class="list-group-item <?php echo $params->is_active ?>" style="border-left: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="<?php echo $params->iconURL()->small ?>" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px"><?php echo $params->fullname ?></p>
		<div class="sqmessage <?php echo $params->status ?>" ></div><?php echo $params->status_title ?>
	</div>
	<div class="clearfix"></div>
</a>