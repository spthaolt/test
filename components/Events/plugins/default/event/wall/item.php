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

$entity = ossn_get_entity($params['post']->item_guid);
$event = ossn_get_event($entity->owner_guid);
if(!$event instanceof Events){
   return;
}
?>
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
                <a class="owner-link" href="<?php echo $params['user']->profileURL(); ?>"> <?php echo $params['user']->fullname; ?> </a>
                <div class="ossn-wall-item-type"><?php echo ossn_print('event:wall:item:created');?></div>
            <?php
            }?>
			</div>
			<div class="post-meta">
				<span class="time-created"><?php echo ossn_user_friendly_time($params['post']->time_created); ?></span>
			</div>
		</div>

       <div class="post-contents event-wall-item">
                <?php
					echo ossn_plugin_view('event/pages/list', array(
						'list' => array(
									$event,				
						),												
					));
				?>
    	</div>
	<?php
		if($event->allowed_comments_likes){
			$vars['entity'] = ossn_get_entity($entity->guid);
			echo ossn_plugin_view('entity/comment/like/share/view', $vars);
		}
	?>    
	</div>
</div>
