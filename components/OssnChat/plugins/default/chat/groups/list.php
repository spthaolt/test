<?php
$user = ossn_loggedin_user();
$groups = ossn_get_user_groups($user);
$have = '';

foreach ($groups as $key => $group) { ?>
	<div class="groups-list-item" id="group-list-item-<?php echo $group->guid; ?>">
	    <div class="groups-item-inner">
	    	<a href="/messages/group/<?php echo $group->guid ?>"><div class="icon"><img class="sqgroup" src="https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png"/></div></a>
	        <a href="/group/<?php echo $group->guid ?>"><div class="name"><?php echo $group->title; ?></div></a>
	    </div>
	</div>
<?php } ?>