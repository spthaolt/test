<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$en = array(
    'groups' => 'Groups',
    'add:group' => 'Add Group',
    'requests' => 'Requests',

    'members' => 'Members',
    'member:add:error' => 'Something went wrong! Please try again later.',
    'member:added' => 'Membership request approved!',

    'member:request:deleted' => 'Membership request declined!',
    'member:request:delete:fail' => 'Cannot decline membership request! Please try again later.',
    'membership:cancel:succes' => 'Membership request cancelled!',
    'membership:cancel:fail' => 'Cannot cancel membership request! Please try again later.',

    'group:added' => 'Successfully created the group!',
    'group:add:fail' => 'Cannot create group! Please try again later.',

    'memebership:sent' => 'Request successfully sent!',
    'memebership:sent:fail' => 'Cannot send request! Please try again later.',

    'group:updated' => 'Group has been updated!',
    'group:update:fail' => 'Cannot update group! Please try again later.',

    'group:name' => 'Group Name',
    'group:desc' => 'Group Description',
    'privacy:group:public' => 'Everyone can see this group and its posts. Only members can post to this group.',
    'privacy:group:close' => 'Everyone can see this group. Only members can post and see posts.',

    'group:memb:remove' => 'Remove',
    'leave:group' => 'Leave Group',
    'join:group' => 'Join Group',
    'total:members' => 'Total Members',
    'group:members' => "Members (%s)",
    'view:all' => 'View all',
    'member:requests' => 'REQUESTS (%s)',
    'about:group' => 'Group About',
    'cancel:membership' => 'Membership cancel',

    'no:requests' => 'No Requests',
    'approve' => 'Approve',
    'decline' => 'Decline',
    'search:groups' => 'Search Groups',

    'close:group:notice' => 'Join this group to see the posts, photos, and comments.',
    'closed:group' => 'Closed group',
    'group:admin' => 'Admin',
	
	'title:access:private:group' => 'Group post',

	// #186 group join request message var1 = user, var2 = name of group
	'ossn:notifications:group:joinrequest' => '%s has requested to join %s',
	'ossn:group:by' => 'By:',
	
	'group:deleted' => 'Group and group contents deleted',
    'group:delete:fail' => 'Group could not be deleted',    
    'group:members:invite' => 'Allow members to send group invite', 
    'group:members:membership' => 'Membership', 
    'group:members:yes' => 'Yes', 
    'group:members:no' => 'No', 
    'group:invite' => 'Group invite',   
    'group:list:title' => 'Friend list',
    'group:invite:name' => 'Name',
    'group:invite:save:null' => 'Please select a friend!',
    'group:invite:success' => 'Invite members successfully!',
    'group:invite:error' => "Invite '%s' failed!",
    'group:membership:open' => "Open",
    'group:membership:inviteonly' => "Invite Only",
    'group:membership:pendingapproval' => "Pending Approval",
    'group:about:desc' => "Description",
    'group:invite:accept:succes' => "Join the group successfully!",
    'group:invite:accept:fail' => "Join group failed! Please try again later.",
    'group:invitation' => "Invitation",
	'group:not:exist' => "Group does not exist! Please try again later.",
    'group:notifications:group:inviterequest' => '%s has invited to join %s',
    'group:list:invitation' => 'List of invitation',
    'group:invite:accept' => 'Accept',
    'group:invite:reject' => 'Reject',
    'group:invite:reject:succ' => 'Refuse to join the group successfully!',
    'group:invite:reject:fail' => 'Refuse to join the group failed!',
    'group:invite:no:invites' => 'No Invites!',
    'group:invite:no:friends' => 'No Friends!',


    

);
ossn_register_languages('en', $en); 
