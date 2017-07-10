<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$vi = array(
	'com:ossn:invite' => 'mời',			
	'com:ossn:invite:friends' => 'mời bạn bè',
	'com:ossn:invite:friends:note' => 'Để mời bạn bè vào, nhập địa chỉ email của họ và một tin nhắn ngắn. Sau đó, họ sẽ nhận được một lời mời.',
	'com:ossn:invite:emails:note' => 'Địa chỉ email (cách nhau bằng dấu phẩy)',
	'com:ossn:invite:emails:placeholder' => 'skyblue@ctu.edu.vn, example@cusc.ctu.edu.vn',
	'com:ossn:invite:message' => 'Lời nhắn',
		
    	'com:ossn:invite:mail:subject' => 'Tiêu đề %s',	
    	'com:ossn:invite:mail:message' => 'Bạn đã được mời %s và %s. Tham gia vào mạng xã hội

%s

Để tham gia, nhấp vào liên kết sau đây:

%s

Liên kết: %s
',	
	'com:ossn:invite:mail:message:default' => 'Chào,

Tôi mời bạn tham gia vào mạng xã hội của tôi %s.
Bấm vào đường link để xem chi tiết : %s

Trân trọng,
%s',
	'com:ossn:invite:sent' => 'Đã gửi lời mời đến: %s.',
	'com:ossn:invite:wrong:emails' => 'Email lỗi: %s.',
	'com:ossn:invite:sent:failed' => 'Không thể gửi lời mời đến các địa chỉ sau: %s.',
	'com:ossn:invite:already:members' => 'Các địa chỉ sau đây đã là thành viên: %s',
	'com:ossn:invite:empty:emails' => 'Vui lòng nhập ít nhất một địa chỉ email',
);
ossn_register_languages('vi', $vi); 
