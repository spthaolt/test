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

$image = $params['image'];
?>
<!-- wall item -->
<div class="ossn-wall-item" id="activity-item-<?php echo $params['post']->guid; ?>">
	<div class="row">
		<div class="meta">
			<img class="user-img" src="<?php echo $params['user']->iconURL()->small; ?>" />
			<div class="post-menu">
				<div class="dropdown">
                 <?php
           			if (ossn_is_hook('wall', 'post:menu') && ossn_isLoggedIn()) {
                		$menu['post'] = $params['post'];
               			echo ossn_call_hook('wall', 'post:menu', $menu);
            			}
            		?>   
				</div>
			</div>
			<div class="user">
           <?php if ($params['user']->guid == $params['post']->owner_guid) { ?>
                <a class="owner-link"
                   href="<?php echo $params['user']->profileURL(); ?>"> <?php echo $params['user']->fullname; ?> </a>
            <?Php
            } else {
                $owner = ossn_user_by_guid($params['post']->owner_guid);
                ?>
                <a href="<?php echo $params['user']->profileURL(); ?>">
                    <?php echo $params['user']->fullname; ?>
                </a>
                <i class="fa fa-angle-right fa-lg"></i>
                <a href="<?php echo $owner->profileURL(); ?>"> <?php echo $owner->fullname; ?></a>
            <?php } ?>
			</div>
			<div class="post-meta">
				<span class="time-created"><?php echo ossn_user_friendly_time($params['post']->time_created); ?></span>
                <span class="time-created"><?php echo $params['location']; ?></span>
                <?php
					echo ossn_plugin_view('privacy/icon/view', array(
							'privacy' => $params['post']->access,
							'text' => '-',
							'class' => 'time-created',
					));
				?>
			</div>
		</div>
		<div class="post-contents">
			<p><?php echo stripslashes($params['text']); ?></p>
			 <?php
						if(!empty($params['friends'])){
	                        foreach ($params['friends'] as $friend) {
								if(!empty($friend)){
	    	                        $user = ossn_user_by_guid($friend);
    	    	                    $url = $user->profileURL();
        	    	                $friends[] = "<a href='{$url}'>{$user->fullname}</a>";
								}
                	        }
							if(!empty($friends)){
								echo '<div class="friends">';
								echo implode(', ', $friends);
								echo '</div>';
							}
						}
              ?>
            <div class="row"> 
                <?php
                if (!empty($params['image']) && $params['image'] && sizeof($params['image']) > 0) {
                    $count = count($params['image']);

                    switch ($count) {
                        case 1:  $first = array_shift($params['image']); ?>
                            <div class="col-xs-12">
                                <img style="width: 100%" src="<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$first}"); ?>"/>
                            </div>
                            <?php
                            break; 
                        case 2: 
                            foreach ($params['image'] as $key => $img): ?>
                                <span class="image-item image-item-height-300 col-xs-6" style="background-image: url(<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$img}"); ?>);">                                        
                                </span>
                            <?php endforeach;                                
                            break;
                        case 3: $first = array_shift($params['image']); ?>
                            <div class="col-xs-12" >
                                <img style="width: 100%" src="<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$first}"); ?>"/>
                            </div>
                            <?php 
                            foreach ($params['image'] as $key => $img): ?>
                                <span class="image-item image-item-height-150 col-xs-6" style="background-image: url(<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$img}"); ?>);">                                    
                                </span>
                            <?php endforeach; 
                            break;
                        default:
                            $first = array_shift($params['image']); ?>
                            <div class="col-xs-12">
                                <img  style="width: 100%" src="<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$first}"); ?>"/>
                            </div>
                            <?php 
                            for ($i=0; $i < 3; $i++): 
                                $img = $params['image'][$i]; ?>
                            
                                <span class="image-item image-item-height-150 col-xs-4 <?= ($i == 2 && $count > 4 ? "number-image" : " ")?>" 
                                style="background-image: url(<?php echo ossn_site_url("post/photo/{$params['post']->guid}/{$img}"); ?>);
                                " >                                        
                                <?php 
                                    if ( $i == 2 && $count > 4 ) {
                                ?>
                                    <div class="number-image-background" >
                                        <div class="number-image-table" > 
                                            <div class="number-image-not-show" > +<?= $count - 4 ?> </div>
                                        </div>
                                    </div>
                                <?php        
                                    } // end if
                                ?>
                                </span>
                        <?php endfor; 

                    } //end switch
                    
                }  // end if
                ?>
            </div>        
		</div>
		<div class="comments-likes">
			<div class="menu-likes-comments-share">
				<?php echo ossn_view_menu('postextra', 'wall/menus/postextra');?>
			</div>
         	<?php
      		  if (ossn_is_hook('post', 'likes')) {
          			  echo ossn_call_hook('post', 'likes', $params['post']);
        		}
      		  ?>           
			<div class="comments-list">
              <?php
          			  if (ossn_is_hook('post', 'comments')) {
                			echo ossn_call_hook('post', 'comments', $params['post']);
           			   }
            		?>            				
			</div>
		</div>
	</div>
</div>
<!-- ./ wall item -->
