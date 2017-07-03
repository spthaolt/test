/**
 * 	Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
Ossn.SendMessage = function($user) {
    Ossn.ajaxRequest({
        url: Ossn.site_url + "action/message/send",
        form: '#message-send-' + $user,
        action:true,
        beforeSend: function(request) {
            $('#message-send-' + $user).find('input[type=submit]').hide();
            $('#message-send-' + $user).find('.ossn-loading').removeClass('ossn-hidden');
        },
        callback: function(callback) {
            $('#message-append-' + $user).append(callback);
            $('#message-send-' + $user).find('textarea').val('');
            $('#message-send-' + $user).find('input[type=submit]').show();
            $('#message-send-' + $user).find('.ossn-loading').addClass('ossn-hidden');
            Ossn.message_scrollMove($user);

        }
    });

};
Ossn.getNewMessages = function($to_guid, $last_id, $type) {
    Ossn.PostRequest({
        url: Ossn.site_url + "messages/getnew/" + $to_guid + "/" + $last_id + "/" + $type,
        action: false,
        callback: function(callback) {
            $('#message-append-' + $to_guid).append(callback);
            if(callback){
            	//Unwanted refresh in message window #416 , there is no need to scroll if no new message.
	            Ossn.message_scrollMove($to_guid);
            }
        }
    });
};

Ossn.getOldMessages = function($to_guid, $first_id, $type) {
    Ossn.PostRequest({
        url: Ossn.site_url + "messages/getold/" + $to_guid + "/" + $first_id + "/" + $type,
        action: false,
        callback: function(callback) {
            $('#message-append-' + $to_guid).prepend(callback);
            if(callback){
                //Unwanted refresh in message window #416 , there is no need to scroll if no new message.
                Ossn.message_scrollMove10Messages($to_guid);
            }
        }
    });
};

Ossn.getMessagesGroup = function($group, $last_time) {
    Ossn.PostRequest({
        url: Ossn.site_url + "messages/getnewgroup/" + $group + "/" + $last_time,
        action: false,
        callback: function(callback) {
            $('#message-append-' + $group).append(callback);
            if(callback){
                Ossn.message_scrollMove($group);
                //Unwanted refresh in message window #416 , there is no need to scroll if no new message.
            }
        }
    });
};
Ossn.getRecent = function($user) {
    Ossn.PostRequest({
        url: Ossn.site_url + "messages/getrecent/" + $user,
        action: false,
        callback: function(callback) {
            $('#get-recent').html(callback);
            $('#get-recent').addClass('inner');
            $('.messages-from').find('.inner').remove();
            $('#get-recent').appendTo('.messages-from');
            $('#get-recent').show();
        }
    });
};
Ossn.playSound = function() {
    document.getElementById('ossn-chat-sound').play();
};
Ossn.message_scrollMove = function(fid) {
    var message = document.getElementById('message-append-' + fid);
    $('.message-inner').animate({scrollTop: message.scrollHeight});
};
Ossn.message_scrollMove10Messages = function(fid) {
    var message = document.getElementById('message-append-' + fid);
    var height = $('#message-append-' + fid + ' div.row:nth-child(10)').offset().top - 50;
    console.log(height);
    $('.message-inner').animate({scrollTop: height});  
};

Ossn.getStatusFriends = function($to_guid, $type) {
    Ossn.PostRequest({
        url: Ossn.site_url + "messages/getstatusfriends/" + $to_guid + "/" + $type,
        action: false,
        callback: function(callback) {
            $('.statusfriends').html(callback);
            if(callback){
                //Unwanted refresh in message window #416 , there is no need to scroll if no new message.
            }
        }
    });
};