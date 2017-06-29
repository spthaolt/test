<div id="get-recent" style="display:none;"></div>
<div class="messages-from">
    <div class="inner">
        <?php
        if ($params['members']) {
            foreach ($params['members'] as $member) {
                $user = ossn_user_by_guid($member->guid);
               
                ?>
	            <div class="row user-item">
					<div class="col-md-2">
                       	<img class="image" src="<?php echo $user->iconURL()->smaller; ?>"/>
             	   	</div>    
             	   	<div class="col-md-10 data">
             	       <div class="name"><a href="/u/<?php echo $user->username ?>"><?php echo strl($user->fullname, 17); ?></a></div>
                	</div>
                </div>
            <?php
            }

        }?>


    </div>
</div>