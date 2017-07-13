<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
if ($params['data']) {
	$data = $params['data'][0];
	$shop_guid = $data->guid;
	$shop_fullname = $data->fullname;
	$shop_sid  = $data->sid;
	$shop_phone  = $data->phone;
}
?>
<div>
	<label><?= ossn_print('shop:owner:fullname:lbl') ?></label>
	<input name="shop_fullname" type="text" value="<?= $shop_fullname ?>" >
</div>
<div>
	<label><?= ossn_print('shop:owner:phone:lbl') ?></label>
	<input name="shop_phone" type="text" value="<?= $shop_phone ?>" >
</div>
<div>
	<label><?= ossn_print('shop:owner:sid:lbl') ?></label>
	<input name="shop_sid" type="text" value="<?= $shop_sid ?>" >
</div>
<div>
	<label><?= ossn_print('shop:owner:image:sid:lbl') ?></label>
	<input name="shop_image_sid" type="file" >
</div>

<input type="hidden" name="shop_guid" value="<?= $shop_guid ?>" >
<input class="btn btn-primary pull-right" value="Lưu" type="submit">
