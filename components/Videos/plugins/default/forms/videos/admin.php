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
 <div>
 	<label><?php echo ossn_print('video:com:ffmpeg:path');?></label>
    <p><?php echo ossn_print('video:com:ffmpeg:path:note');?></p>
    <input type="text" name="ffmpeg" value="<?php echo $params['video']->ffmpeg_path;?>" />
 </div>
 <div>
 	<label><?php echo ossn_print('video:com:ffmpeg:status');?></label>
    <p><?php echo ossn_video_is_ffmpeg_exists();?></p>
 <div>
 <div>
 	<input type="submit" class="btn btn-success"/>
 </div>
