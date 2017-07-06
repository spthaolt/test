
Ossn.RegisterStartupFunction(function() {
	$(document).ready(function() {
		 $('#group-invite-check-all').click(function() {
        	$aa = $(this).is(':checked');
			alert($aa);
		});
	});
});