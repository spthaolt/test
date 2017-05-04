<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
	$settings = $params['settings'];
 ?>
 <div>
 	<label><?php echo ossn_print('ssdkv3:apikey');?></label>
    <?php 
		echo ossn_plugin_view('input/text', array(
				'name' => 'apikey',
				'value' => $settings->apikey,
		));
	?>		
 </div>
 <div>
 	<label><?php echo ossn_print('ssdkv3:secret');?></label>
    <?php 
		echo ossn_plugin_view('input/text', array(
				'name' => 'secret',
				'value' => $settings->secret,
		));
	?>		
 </div> 
 <div>
 	<label><?php echo ossn_print('ssdkv3:username');?></label>
    <?php 
		echo ossn_plugin_view('input/text', array(
				'name' => 'username',
				'value' => $settings->username,
		));
	?>		
 </div> 
 <div class="margin-top-10">
 	<input type="submit" class="btn btn-success" value="<?php echo ossn_print('save');?>" />
 </div>
 <div class="margin-top-10">
 	<p><?php echo ossn_print('ssdkv3:notes');?></p>
    <textarea readonly="readonly"><?php echo SDKv3::genenToken();?></textarea>
 </div>