<script type="text/javascript">
    Ossn.SendMessage(<?php echo $params['to_guid'];?>);
    $(document).ready(function () {
        setInterval(function () {
        	var last_id = $("#message-append-<?php echo $params['to_guid'] ?> div.row:last").find('.time-created').attr('data_id');
        	$('.group_message_last_id').val(last_id);
        	<?php if ($params['page'] == "group") { ?> 
        		var type = "group";
    		<?php } else { ?>
    			var type = "individual";	
        	<?php }?>
            Ossn.getNewMessages('<?php echo $params['to_guid'];?>', last_id, type);
            Ossn.getStatusFriends('<?php echo $params['to_guid'];?>', type);
        }, 5000);
       	Ossn.message_scrollMove(<?php echo $params['to_guid'];?>);
	});
</script>


<script type="text/javascript">
	
	$(document).on('keypress', '.input_message', function(e) {
		if (e.keyCode == 13 && e.shiftKey) {
            if ($('.input_message').val() == '') return false;
            $('.message-form-form').submit();
	    }
	});
	$('.message-inner.sqmessage').scroll(function() {

		if ($(this).scrollTop() == 0) {

			var first_id = $("#message-append-<?php echo $params['to_guid'] ?> div.row:first").find('.time-created').attr('data_id');
        	<?php if ($params['page'] == "group") { ?> 
        		var type = "group";
    		<?php } else { ?>
    			var type = "individual";	
        	<?php }?>
        	Ossn.getOldMessages('<?php echo $params['to_guid'];?>', first_id, type);

		}
	});
</script>