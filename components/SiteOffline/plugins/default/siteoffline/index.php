<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
?>
<div class="row ossn-page-contents">
       <div class="col-md-6 col-center siteoffline">
    	<?php 
			$contents = ossn_view_form('login2', array(
        					'action' => ossn_site_url('action/user/login')
	   	 	));
			$heading = "<p>".ossn_print('its:free')."</p>";
			$login =  ossn_plugin_view('widget/view', array(
						'title' => ossn_print('siteoffline:login'),
						'contents' => $contents,
			));
			$siteofflin_top = ossn_plugin_view('siteoffline/top');
			echo ossn_plugin_view('widget/view', array(
						'title' => ossn_print('siteoffline'),
						'contents' => $siteofflin_top .$login,
			));			
			?>	       			
       </div>     
</div>	
