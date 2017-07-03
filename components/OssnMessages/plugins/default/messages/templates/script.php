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
        setInterval(function () {
            var last_id = $("#message-append-$to_guid div.row:last").find('.time-created').attr('data_id');
            $('.group_message_last_id').val(last_id);
            var type = "$type";
            Ossn.getNewMessages($to_guid, last_id, type);
            Ossn.getStatusFriends($to_guid, type);
        }, 5000);
        Ossn.message_scrollMove($to_guid);
    });
    $(document).on('keypress', '.input_message', function(e) {
        if (e.keyCode == 13 && e.shiftKey) {
            if ($('.input_message').val() == '') return false;
            if ($('.spam_check').val() == "true") {
                $('.spam_check').val("false");
                $('.message-form-form').submit();
            }
        }
    });
    $('.message-inner.sqmessage').scroll(function() {

        if ($(this).scrollTop() == 0) {

            var first_id = $("#message-append-$to_guid div.row:first").find('.time-created').attr('data_id');
            var type = "$type";
            Ossn.getOldMessages($to_guid, first_id, type);

        }
    });

TEXT;

ossn_extend_onload_js($html);
?>
