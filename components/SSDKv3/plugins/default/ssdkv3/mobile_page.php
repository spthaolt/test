<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
	$component = new OssnComponents;
	$settings  = $component->getSettings("SSDKv3");
?>
<div class="row">
	<div class="col-md-12">
    	<div class="ossn-page-contents">
        	<p><?php echo ossn_print('ssdkv3:ui:notes');?></p>
            <p><strong><?php echo ossn_print('ssdkv3:ui:hostname');?> </strong><?php echo $settings->username;?></p>
            <p><strong><?php echo ossn_print('ssdkv3:ui:username');?> </strong><?php echo ossn_print('ssdkv3:ui:yourusername');?></p>
            <p><strong><?php echo ossn_print('ssdkv3:ui:password');?> </strong><?php echo ossn_print('ssdkv3:ui:yourpassword');?></p>
            <a target="_blank" href="https://play.google.com/store/apps/details?id=softlab24.ossn.app"><img src="<?php echo ossn_site_url();?>components/SSDKv3/images/playstore.png" style="width:150px;"/></a>
        </div>
    </div>
</div>