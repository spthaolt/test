<?php
$friends = ossn_loggedin_user()->getFriends();

if ($friends) {
$num = 0; 
?>
<table class="table table-striped group-invite-table">
	<thead>
  		<tr>
        	<th class="checkbox-width" ><input type="checkbox" id="group-invite-check-all"> </th>
        	<th> <?php echo ossn_print("group:invite:name"); ?> </th>
  		</tr>
	</thead>
    <tbody>
    	<?php foreach ($friends as $friend) { ?>
    		<?php if ((!$params['group']->isMember(NULL, $friend->guid)) && 
    				(!$params['group']->inviteExists($friend->guid, false))) { ?>
    			<?php $num += 1; ?>		
		     	<tr>
			        <td class="invite-checkbox">
						<input type="checkbox" name="friend[]" id="friend_<?= $friend->guid ?>" value="<?= $friend->guid ?>">
			        </td>
			        <td>
			        	<label class="invite-title" for="friend_<?= $friend->guid ?>">
			        		<img src="<?= $friend->iconURL()->topbar ?>"> <?= $friend->fullname ?>
			        	</label>
			        </td>
		      	</tr>
			<?php } ?>      	
	    <?php } ?>  
	    <?php if ($num == 0) { ?>
			<tr>
				<td colspan="2">
					No data
				<td>
			</tr>
	    <?php } ?>	
    </tbody>
</table>

<input type="hidden" value="<?php echo $params['group']->guid; ?>" name="group"/>
<input type="submit" class="ossn-hidden" id="group-invite-submit"/>
<?php } ?>


<script type="text/javascript">
    $(document).ready(function () {
        $('#group-invite-check-all').click(function() {
        	$result = $(this).is(':checked');
			
			if($result) 
				$('input[type="checkbox"]').prop("checked", true);
			else 
				$('input[type="checkbox"]').prop("checked", false);
			
		});
    });

</script>

