<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

//unused pagebar skeleton when ads are disabled #628  
 if(com_is_active('OssnAds')){
	 $ads = ossn_plugin_view('ads/page/view');
 	 $ads = trim($ads);
 }
?>
<div class="col-sm-12">
	<div class="row">
       <?php echo ossn_plugin_view('theme/page/elements/system_messages'); ?>    
		<?php echo $params['content']; ?>
	</div>
</div>