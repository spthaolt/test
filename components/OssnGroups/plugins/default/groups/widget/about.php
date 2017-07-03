<?php 

?>
<div>
	<label > <?php echo ossn_print('group:about:desc'); ?> : </label> 
	<span> <?php echo $params['group']->description ?> </span>
</div>
<div>
	<label > <?php echo ossn_print('privacy'); ?> : </label> 
	<?php 
		if ($params['group']->membership == 1) $textMembership = ossn_print('close');
		else $textMembership = ossn_print('public');
	?>
	<span> <?php echo $textMembership ?> </span>
</div>
<div>
	<label > <?php echo ossn_print('group:members:invite'); ?> : </label>
	<?php 
		if ($params['group']->membInvite == 1) $textMembInvite = ossn_print('group:members:yes');
		else $textMembInvite = ossn_print('group:members:no');
	?> 
	<span> <?php echo $textMembInvite ?> </span>
</div>
<div>
	<label > <?php echo ossn_print('group:members:membership'); ?> : </label> 
	<?php 
		if ($params['group']->membship == 1) $textMembship = ossn_print('group:membership:open');
		elseif ($params['group']->membship == 2) $textMembship = ossn_print('group:membership:inviteonly');
		else	$textMembship = ossn_print('group:membership:pendingapproval');
	?> 
	<span> <?php echo $textMembship ?> </span>
</div>
