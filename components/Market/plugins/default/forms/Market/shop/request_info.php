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
	$shop_name = $data->title;
	$shop_url  = $data->friendlyUrl;
}
?>
<div>
	<label><?= ossn_print('shop:name:lbl') ?></label>
	<input name="shop_name" type="text" value="<?= $shop_name ?>" >
</div>
<div>
	<label><?= ossn_print('shop:friendly:url:lbl') ?></label>
	<div class="input-group">
	  <span class="input-group-addon" style="border-radius: 0px"><?= SHOP_URL ?></span>
	  <input style="margin: 0px;" type="text" name="shop_url" value="<?= $shop_url ?>" >
	</div>
</div>
<input type="hidden" name="shop_guid" value="<?= $shop_guid ?>" >
<input class="btn btn-primary pull-right" value="Lưu" type="submit">