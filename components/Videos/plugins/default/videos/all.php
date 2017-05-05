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
 $videos = new Videos;
 $owner = input('owner_guid');
 if(empty($owner)){
	 $all = $videos->getAll();
 	 $count = $videos->getAll(array('count' => true));
 } else {
	 $all = $videos->getAll(array(
			'owner_guid' => $owner
	 ));
 	 $count = $videos->getAll(array(
		'count' => true,
		'owner_guid' => $owner,
	 ));
 }
 if($all){
	echo "<div class='ossn-videos-list'>";
	foreach($all as $video){
		?>
        	<div class="row ossn-video-item">
            	<div class="col-md-12">
            		
                    <a href="<?php echo $video->getURL();?>">
                    	<div class="video-image" style="background:url('<?php echo $video->getCoverURL();?>');background-size: cover;"></div>
                    </a>
            		<div class="video-meta-data">
                    	
                        <div class="video-title">
                        		<a href="<?php echo $video->getURL();?>"><?php echo $video->title;?></a>
                        </div>
                        <div class="description">
                        	<?php echo strl($video->description, 200); ?>
                        </div>
                        <div class="time-created"><?php echo ossn_user_friendly_time($video->time_created); ?></div>
                    </div>  
                    
                                      
                </div>
            </div>
        <?php	
	}
	echo ossn_view_pagination($count);
	echo "</div>";
 }