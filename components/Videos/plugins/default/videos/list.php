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
 ?>
 <div class="ossn-page-contents">
 	<?php 
		echo ossn_plugin_view('widget/view', array(
				'title' => ossn_print('video:com:all'), 
				'contents' => ossn_plugin_view('videos/all'),
		));
	?>
 </div>