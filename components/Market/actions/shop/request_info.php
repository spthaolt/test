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
use Market\catalog\Shop;
use Market\catalog\ShopEntity;

$shop = new Shop;
$params['owner_guid'] = ossn_loggedin_user()->guid;
$params['shop_guid'] = input('shop_guid');
$params['shop_name'] = input('shop_name');
$params['shop_url'] = input('shop_url');
$params['privacy'] = OSSN_PRIVATE;

if ($shop->requestShop($params)) {
    ossn_trigger_message(ossn_print('shop:requested'), 'success');
    redirect("s/request");
} else {
    ossn_trigger_message(ossn_print('shop:request:fail'), 'error');
    redirect(REF);
}

