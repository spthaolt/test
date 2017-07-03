
.ossn-messages {

}
.ossn-messages .messages-recent .widget-contents {
	padding:0px;
}
.ossn-messages .messages-recent .messages-from {
    max-height: 555px;
    overflow-x: hidden;
    overflow-y: auto;
}
.ossn-messages .messages-recent .messages-from .user-item {
    padding: 10px;
    margin: 0px;
	cursor:pointer;
    border-bottom: 1px solid #eee;    
}
.ossn-messages .messages-recent .messages-from .user-item .image {
    margin-top: 3px;
	border-radius: 16px;
}
.ossn-messages .messages-recent .messages-from .user-item .name {
       font-weight: bold;
    display: inline-block;
        font-size: 13px;
}
.ossn-messages .messages-recent .messages-from .message-new {
    background: #F7F7F7;
}
.ossn-messages .messages-recent .messages-from .user-item .col-md-10,
.ossn-messages .messages-recent .messages-from .user-item .col-md-2 {
	padding:0px;
}
.ossn-messages .messages-recent .messages-from .user-item .reply {
    margin-top: 0px;
    font-size: 13px;
}
.ossn-notification-messages .fa-reply,
.ossn-messages .messages-recent .messages-from .user-item .reply .fa-reply {
	font-size:10px;
    display: inline-block;  
    margin-top:0px;
}
.ossn-messages .messages-recent .messages-from .user-item .reply .reply-text {
	display: inline-block;  
}
.ossn-messages .messages-recent .messages-from .user-item .time {
    display: inline-block;
    float: right;
}
.ossn-messages .message-with  .user-icon {
    margin-top: 15px;
	border-radius: 25px;
}
.ossn-messages. message-form-form .textarea {

}
.ossn-messages .message-inner {
    max-height: 400px;
    padding-right: 20px;
    overflow-y: auto;
    overflow-x: hidden;
}
.ossn-messages .message-inner .row {
    margin-left: -10px;
}
.message-form-form {
    margin-top: 10px;
    border-top: 1px solid #eee;
    padding-top: 10px;
}
.ossn-messages .message-with .time-created {
	float:right;
    margin-left:5px;
}
/*************************
	Notifications
**************************/

.ossn-notification-messages  .user-item {
	padding: 4px;
	border-bottom: 1px solid #eee;
}
.ossn-notification-messages .user-item:hover {
	background:#F6F7F8;
	cursor:pointer;
}
.ossn-notification-messages .message-new {
	background:#eee;
}
.ossn-notification-messages  .user-item .image {
	display:inline-table;
	width:50px;
	height:50px;
}
.ossn-notification-messages .user-item .data{
	float:right;
	width: 335px;
}
.ossn-notification-messages .user-item .data .name{
	font-size: 13px;
	font-weight: bold;
	padding: 3px;
    	margin-top: -3px;
    	text-overflow: ellipsis;
    	width: 210px;
    	white-space: nowrap;
    	overflow: hidden;
}
.ossn-notification-messages .user-item-inner .time {
	color: #999;
	float:right;
      	font-size: 14px;
    	font-style: italic;
    	margin-top: -24px;
}
.ossn-notification-messages .reply-text,
.ossn-notification-messages .reply-text-from {
	margin-top: -0px;
	margin-left: 4px;
	text-overflow: ellipsis;
	width: 320px;
	white-space: nowrap;
	overflow: hidden;
}
.ossn-notification-messages .messages-from .time {
	color: #999;
	float:right;
}
.ossn-notification-messages .user-item-inner {
	padding: 5px;
}
/************************
	v4.0 chat message
*************************/
.message-box-recieved {
    background-color: #F2F2F2;
    border-radius: 5px;
    box-shadow: 0 0 6px #B2B2B2;
    display: inline-block;
    padding: 10px 18px;
    position: relative;
    vertical-align: top;
    float: left;
    margin: 10px 0px 10px 10px;
    border-color: #cdecb0;
    word-break: break-word;
    text-align: justify;
}
.message-box-recieved::before {
    background-color: #F2F2F2;
    content: "\00a0";
    display: block;
    height: 16px;
    position: absolute;
    top: 11px;
    transform: rotate( 29deg) skew( -35deg);
    -moz-transform: rotate( 29deg) skew( -35deg);
    -ms-transform: rotate( 29deg) skew( -35deg);
    -o-transform: rotate( 29deg) skew( -35deg);
    -webkit-transform: rotate( 29deg) skew( -35deg);
    width: 20px;
    box-shadow: -2px 2px 2px 0 rgba( 178, 178, 178, .4);
    left: -9px;
}
.message-box-sent {
    background-color: #dfeecf;
    border-radius: 5px;
    box-shadow: 0 0 6px #B2B2B2;
    display: inline-block;
    padding: 10px 18px;
    position: relative;
    vertical-align: top;
    float: left;
    margin: 5px 45px 5px 20px;
    border-color: #cdecb0;
    word-break: break-word;
    text-align: justify;
}
.message-box-sent::before {
    float: right;
    background-color: #dfeecf;
    content: "\00a0";
    display: block;
    height: 19px;
    position: relative;
    left: 26px;
    top: 0px;
    transform: rotate( 205deg) skew( -35deg);
    -moz-transform: rotate( 205deg) skew( -35deg);
    -ms-transform: rotate( 205deg) skew( -35deg);
    -o-transform: rotate( 205deg) skew( -35deg);
    -webkit-transform: rotate( 205deg) skew( -35deg);
    width: 20px;
    box-shadow: -2px 2px 2px 0 rgba( 178, 178, 178, .4);
}
.message-box-sent {
    float: right;
    background-color: #dfeecf;
    border-radius: 5px;
    box-shadow: 0 0 6px #B2B2B2;
    display: inline-block;
    padding: 10px 18px;
    position: relative;
    vertical-align: top;
    margin: 10px 0px;
    border-color: #cdecb0;
}

.messages-with .widget-contents {
    padding: 10px 0px;
}


.thumbnail.sqmessage {
    position: fixed;
    top: 50px;
    bottom: 0;
    left: 0;
    right: 0;
    border: 0;
    padding: 0;
    height: 100%;
}

.col-sm-3.sqmessage {
    padding: 0;
    z-index: 0;
    height: 100%;
    position: relative;
}

.list-group.sqmessage {
    left: 0px;
    right: 0px;
    bottom: 100px;
    overflow-x: hidden;
    position: absolute;
    top: 0px;
}

.col-sm-6.sqmessage {
    position: relative;
    height: 100%;
    border-left: 1px solid #eee;
    border-right: 1px solid #eee;
    z-index: 0;
    padding: 0;
}

.message-inner.sqmessage {
    position: absolute;
    left: 0px;
    right: 0px;
    top: 0px;
    bottom: 218px;
    overflow-x: hidden;
}

.ossn-form.message-form-form.sqmessage {
    position: absolute;
    bottom: 120px;
    left: 0;
    right: 0;
    margin: 10px;
}

.ossn-form.message-form-form.sqmessage .btn.btn-primary {
    float:right;
    margin-top: -36px;
}

textarea[name=message] {
    resize: none;
}

.sqmessage .list-group-item:first-child, .sqmessage .list-group-item:last-child {
    border-radius: 0;
}
.sqmessage .list-group-item.active,.sqmessage  .list-group-item.active:focus,.sqmessage  .list-group-item.active:hover {
    z-index: 2;
    color: #000;
    background-color: #05a89f;
    border-color: #05a89f;
}

.sqmessage.ossn-message-icon-online {
    width: 10px; 
    height: 10px; 
    background-color: rgb(66, 183, 42); 
    border-radius: 50%; 
    float: left; 
    margin-top: 6px; 
    margin-right: 5px;
}

.sqmessage.ossn-message-icon-offline {
    width: 10px; 
    height: 10px; 
    background-color: rgb(123, 123, 123); 
    border-radius: 50%; 
    float: left; 
    margin-top: 6px; 
    margin-right: 5px;
}

.sqmessage.comment-container .emojii-container-main {
    margin-top: -270px;
}

.sqmessage.comment-container .ossn-comment-attach-photo {
    position: absolute;
    top: 50px;
    width: 0px;
    right: 110px;
}

.sqmessage.comment-container .sqmessage.ossn-comment-attach-photo {
    right: 80px;
}

.sqmessage.comment-container .ossn-comment-attach-photo i {
    float: left;
}