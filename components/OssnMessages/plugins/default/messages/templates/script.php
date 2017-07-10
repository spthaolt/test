<?php

$to_guid = $params['to_guid'];
$page = $params['page'];
if ($page == "group") {
    $type = "group";
} else {
    $type = "individual";
}
$html = <<<TEXT
Ossn.SendMessage($to_guid);
$(document).ready(function () {
    setTimeout(function(){ 
            Ossn.message_scrollMove($to_guid);
    }, 1000);
    var that = $("#message-append-$to_guid div.row:last");
    var last_id = that.find('.message_id').val();
    if (typeof last_id === "undefined") last_id = 0;

    $('.group_message_last_id').val(last_id);
    var type = "$type";
        Ossn.getNewMessages($to_guid, last_id, type);
    
    setInterval(function () {
        Ossn.getStatusFriends($to_guid, type);
    }, 5000);
});
$(document).on('keypress', '.input_message', function(e) {
    if (e.keyCode == 13) {
        if (!e.shiftKey) {
            if ($('.input_message').val() == '') return false;
            if ($('.spam_check').val() == "true") {
                $('.spam_check').val("false");
                $('.message-form-form').submit();
            }
        }
    }
    
});

$(document).ready(function(){
    $('.scrollbar-macosx').scrollbar();
    setTimeout(function(){ 
        $('.message-inner.sqmessage').scroll(function() {
            if ($(this).scrollTop() == 0) {
                var that = $("#message-append-$to_guid div.row:first");
                var first_id = that.find('.message_id').val();
                if (typeof first_id === "undefined") first_id = 0;
                var type = "$type";
                Ossn.getOldMessages($to_guid, first_id, type);
            }
        });
    }, 5000);
});
TEXT;

ossn_extend_onload_js($html);
?>
