<?php
$name = ossn_print('product:name');
$html = '<div class="ossn-wall-product"><input type="text" placeholder="'.$name.'" name="product[name]" /></div>'
?>
$(document).on('click', ' .ossn-wall-container-control-menu-product', function() {
	if ($('.ossn-wall-container-data-post div').hasClass('ossn-wall-product')) {
		$('.ossn-wall-product').remove();
	} else {
		$('.ossn-wall-container-data-post .controls').before($('<?php echo $html ?>'));
	}
});

Ossn.RegisterStartupFunction(function() {
    Ossn.PostProduct = function() {
    	alert('as');
    }
});