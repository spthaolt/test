<?php
$user = ossn_loggedin_user();
$groups = ossn_get_user_groups($user);
$have = '';

foreach ($groups as $key => $group) { ?>
    <div class="groups-list-item" id="groups-list-item-<?php echo $groups->guid; ?>"
         onClick="Ossn.Redirect(<?php echo $group->guid ?>)">
        <div class="groups-item-inner">
            <div class="icon"><img src="<?php echo $group->avatarURL('smaller'); ?>"/></div>
            <div class="name"><?php echo $group->title; ?></div>
        </div>
    </div>
<?php } ?>
