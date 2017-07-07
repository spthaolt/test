<?php
//var_dump($params['profile']);

$group = new OssnGroup();

$invites = $group->getInvitesToGroups($params['profile']->guid);
$current_user_id = ossn_loggedin_user()->guid;
?>

<div class="col-md-11 col-xs-12">
    <h2 class=""><?php echo ossn_print("group:list:invitation"); ?></h1>
    <?php if ($invites) { ?> 
    <div class="list-group">
        <?php  foreach ($invites as $invite) { ?>
        <div class="list-group-item group-invites">
            <div class="col-md-2 col-sm-2 hidden-xs group-no-padding">
                <img src="<?php echo $invite->avatarURL("large"); ?>" width="100" height="100"/>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="group-invites-info">
                    <div>
                        <a href="<?php echo ossn_group_url($invite->guid); ?>"><?php echo $invite->title; ?></a>
                    </div>
                    <div>
                        <span><?php echo $invite->description; ?></span>
                    </div>
                </div>
                <div class="group-invites-control">
                    <a href="<?php echo ossn_site_url("action/group/member/accept?group={$invite->guid}&user={$current_user_id}", true); ?>" class="btn btn-success"> <?php echo ossn_print("group:invite:accept"); ?> </a>
                    <a href="<?php echo ossn_site_url("action/group/member/reject?group={$invite->guid}&user={$current_user_id}", true); ?>" class="btn btn-danger"> <?php echo ossn_print("group:invite:reject"); ?> </a>
                </div>
            </div>

        </div>
        <?php } ?>
    </div>
    <?php } else { ?>    
        <div class="alert alert-info">
          <strong> <?php echo ossn_print("group:invite:no:invites"); ?></strong>
        </div>
    <?php } ?>    
</div>	



  
