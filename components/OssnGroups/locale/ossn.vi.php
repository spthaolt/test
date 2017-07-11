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
  'groups' => 'Nhóm',
  'add:group' => 'Tạo nhóm',
  'requests' => 'Thắc mắc',

  'members' => 'Thành viên',
  'member:add:error' => 'Đã xảy ra lỗi! Vui lòng thử lại sau.',
  'member:added' => 'Chấp nhận yêu cầu!',

  'member:request:deleted' => 'Từ chối gia nhập!',
  'member:request:delete:fail' => 'Không thể từ chối yêu cầu thành viên! Vui lòng thử lại sau.',
  'membership:cancel:succes' => 'Thành viên đã hủy yêu cầu',
  'membership:cancel:fail' => 'Không thể hủy bỏ yêu cầu thành viên! Vui lòng thử lại sau.',

  'group:added' => 'Tạo nhóm thành công',
  'group:add:fail' => 'Không thể taih nhóm! Vui lòng thử lại',

  'memebership:sent' => 'Yêu cầu đã được gửi',
  'memebership:sent:fail' => 'Không thể gửi yêu cầu! Vui lòng thử lại.',

  'group:updated' => 'Đã cập nhật thành công',
  'group:update:fail' => 'Không thể cập nhật vui lòng thử lại sao.',

  'group:name' => 'Tên nhóm',
  'group:desc' => 'Giới thiệu:',
  'privacy:group:public' => 'Mọi người có thể nhìn thấy nhóm này và các bài viết của nhóm. Chỉ có thành viên có thể đăng bài trong nhóm này.',
  'privacy:group:close' => 'Mọi người có thể nhìn thấy nhóm này. Chỉ có thành viên có thể đăng bài và xem bài.',
  'group:about:desc' => "Giới thiệu",

  'group:memb:remove' => 'Kick',
  'leave:group' => 'Rời nhóm',
  'join:group' => 'Xin vào nhóm',
  'total:members' => 'Tổng thành viên',
  'group:members' => "Thành viên (%s)",
  'view:all' => 'Xem hết',
  'member:requests' => 'Yêu cầu (%s)',
  'about:group' => 'Thông tin nhóm',
  'cancel:membership' => 'Membership cancel',

  'no:requests' => 'Không có thông báo',
  'approve' => 'Tán thành',
  'decline' => 'Từ chối',
  'search:groups' => 'Tìm nhóm',

  'close:group:notice' => 'Tham gia nhóm này để xem các bài viết, hình ảnh, và ý kiến.',
  'closed:group' => 'nhóm kín',
  'group:admin' => 'Quản trị',

	'title:access:private:group' => 'Bài đăng',

	// #186 group join request message var1 = user, var2 = name of group
	'ossn:notifications:group:joinrequest' => '%s đã yêu cầu tham gia %s',
	'ossn:group:by' => 'Bởi:',


	'group:deleted' => 'Nhóm và nhóm nội dung đã bị xóa',
	'group:delete:fail' => 'Nhóm không thể bị xóa',

  'group:invite' => 'Gởi lời mời nhóm',
  'group:list:invitation' => 'Danh sách mời nhóm',
  'group:invite:accept' => 'Đồng ý',
  'group:invite:reject' => 'Từ chối',
  'group:invite:reject:succ' => 'Bạn đã từ chối tham gia nhóm!',
  'group:invite:reject:fail' => 'Có lỗi xảy ra. Vui lòng thử lại!',
  'group:invite:no:invites' => 'Không có lời mời nhóm nào!',
  'group:invite:no:friends' => 'Không có bạn bè!',
  'group:members:invite' => 'Thành viên có thể mời vào nhóm?',
  'group:members:no' => 'Không',
  'group:members:yes' => 'Có',
  'group:membership:inviteonly' => 'Chỉ mời',
  'group:membership:open' => 'Mở',
  'group:membership:pendingapproval' => 'Chờ duyệt',
  'group:members:membership' => 'Thành viên tham gia',

  'group:invite:name' => 'Danh sách bạn bè',
  'group:list:title' => 'Gởi lời mời nhóm'

);
ossn_register_languages('vi', $vi);
