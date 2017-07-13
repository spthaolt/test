<?php
$shop_create_btn = '<a id="shop-create-btn" href="'.SHOP_URL.'request" class="btn-action">'.ossn_print('shop:request:lbl').'</a>';
$name = ossn_print('product:name');
$html = '<div class="ossn-wall-product"><input type="text" placeholder="'.$name.'" name="product[name]" /></div>';


?>
$(document).on('click', '.ossn-wall-container-control-menu-product', function() {
	if ($('.ossn-wall-container-data-post div').hasClass('ossn-wall-product')) {
		$('.ossn-wall-product').remove();
	} else {
		$('.ossn-wall-container-data-post .controls').before($('<?php echo $html ?>'));
	}
});

$('#profile-menu').prepend('<?php echo $shop_create_btn ?>');
