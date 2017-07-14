<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$shop = $params[0];
$user = ossn_loggedin_user();
$cover = new OssnProfile;

$coverp = $cover->coverParameters($user->guid);
$cover = $cover->getCoverURL($user);

if(!empty($coverp[0])){
	$cover_top = "top:{$coverp[0]};";
}
if(!empty($coverp[1])){
	$cover_left = "left:{$coverp[1]};";
}
if (ossn_isLoggedIn()) {
    $class = 'ossn-profile';
} else {
    $class = 'ossn-profile ossn-profile-tn';
}
$guard = ossn_site_url('components/Market/images/guard.svg');
$imageIntro = ossn_site_url('components/Market/images/cover.png');
?>
<div class="ossn-profile container">
	<div class="row">
    	<div class="col-md-11">
			<div class="<?php echo $class; ?>">
				<div class="top-container">
					<div id="container" class="profile-cover">
						<?php if (ossn_loggedin_user()->guid == $user->guid) { ?>
						<div class="profile-cover-controls">
							<a href="javascript:void(0);" onclick="Ossn.Clk('.coverfile');" class='btn-action change-cover'>
								<?php echo ossn_print( 'change:cover'); ?>
							</a>
							<a href="javascript:void(0);" id="reposition-cover" class='btn-action reposition-cover'>
								<?php echo ossn_print( 'reposition:cover'); ?>
							</a>
						</div>
						<form id="upload-cover" style="display:none;" method="post" enctype="multipart/form-data">
							<input type="file" name="coverphoto" class="coverfile" onchange="Ossn.Clk('#upload-cover .upload');" />
							<?php echo ossn_plugin_view( 'input/security_token'); ?>
							<input type="submit" class="upload" />
						</form>
						<?php } ?>
						<img id="draggable" class="profile-cover-img" src="<?php echo $cover; ?>" style='<?php echo $cover_top; ?><?php echo $cover_left; ?>' />
					</div>
					<div class="profile-photo">
						<?php if (ossn_loggedin_user()->guid == $user->guid) { ?>
						<div class="upload-photo" style="display:none;cursor:pointer;">
							<span onclick="Ossn.Clk('.pfile');"><?php echo ossn_print('change:photo'); ?></span>

							<form id="upload-photo" style="display:none;" method="post" enctype="multipart/form-data">
								<input type="file" name="userphoto" class="pfile" onchange="Ossn.Clk('#upload-photo .upload');" />
								<?php echo ossn_plugin_view( 'input/security_token'); ?>
								<input type="submit" class="upload" />
							</form>
						</div>
						<?php } 
						$viewer= '' ; 
						if (ossn_isLoggedIn() && get_profile_photo_guid($user->guid)) { 
								$viewer = 'onclick="Ossn.Viewer(\'photos/viewer?user=' . $user->username . '\');"';
						}
						?>
						<img src="<?php echo $user->iconURL()->larger; ?>" height="170" width="170" <?php echo $viewer; ?> />
					</div>
					<div class="user-fullname">Siêu thị tại gia</div>
					<div id="profile-hr-menu" class="profile-hr-menu" style="background-color: #fff">
						<div class="row">
							<div class="col-sm-8">
								<ul>
								    <li <?= ($params['step'] == 'info')?'class="active"':'' ?> ><a href="<?= SHOP_URL.$shop->friendly_url ?>">Cửa hàng</a></li>
								    <li <?= ($params['step'] == 'owner')?'class="active"':'' ?> ><a href="<?= SHOP_URL.$shop->friendly_url.'/info' ?>">Giới thiệu</a></li>
								    <li <?= ($params['step'] == 'confirm')?'class="active"':'' ?> ><a href="<?= SHOP_URL.$shop->friendly_url.'/policy' ?>">Chính sách</a></li>
								    <li <?= ($params['step'] == 'confirm')?'class="active"':'' ?> ><a href="<?= SHOP_URL.$shop->friendly_url.'/contact' ?>">Liên hệ</a></li>
								</ul>
							</div>
							<div class="col-sm-4">
								<div class="profile-buttons pull-right" style="margin-top: 10px;margin-right: 10px;">
		                            <a href="http://ossn.dev/g/fgfd-5/edit" class="btn btn-default">Theo dõi</a>
		                       	</div>
							</div>
						</div>
					</div>  
					<div id="cover-menu" class="profile-menu">
						<a href="javascript:void(0);" onclick="Ossn.repositionCOVER();" class='btn-action'>
							<?php echo ossn_print('save:position'); ?>
						</a>
					</div>
				</div>

			</div>   
          </div>   
    </div>
	<div class="row ossn-profile-bottom">
        <div class="col-md-3">
			<div class="page-sidebar">
				<div class="ossn-widget widget-description">
					<div class="widget-heading">Thông tin cửa hàng</div>
					<div class="widget-contents">
						<span><i class="fa fa-map-marker"></i>98/37 Đường Phan Huy Ích, Phường 15, Tân Thới Hiệp</span>
						<hr>
						<fieldset class="rating">
						    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
						    <input checked="true" type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
						    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
						    <input  type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
						    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
						    <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
						    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
						    <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
						    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
						    <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
						</fieldset>
						<div class="clearfix"></div>
						<div>
							<label> Được đánh giá tốt : </label> 
							<span> 93,2% </span>
						</div>
						<div>
							<label> Giao dịch thành công : </label> 
							<span> 6.061 </span>
						</div>
						<div>
							<label> Thời gian xử lí đơn : </label> 
							<span> 5 giờ </span>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<img src="<?= $guard ?>" width="100%" />
							</div>
							<div class="col-sm-8">
								Bạn hãy đặt hàng qua ezqua.com để được bảo vệ.
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<a href="#" class="btn btn-success btn-block" style="margin-bottom: 10px">Chat với cửa hàng</a>
				<div class="ossn-widget widget-description">
					<div class="widget-heading">Danh mục</div>
					<div class="widget-contents" style="padding-left:0px; padding-right: 0px">
						<div class="list-group" style="border-radius: 0px;">
							<a href="#" class="list-group-item" style="border-radius: 0px">Tabletes</a>
							<a href="#" class="list-group-item">Desktops</a>
							<a href="#" class="list-group-item">Software</a>
							<a href="#" class="list-group-item">Phone</a>
							<a href="#" class="list-group-item" style="border-radius: 0px">Camera</a>
						</div>
					</div>
				</div>
				<div class="ossn-widget widget-description">
					<div class="widget-heading">Khuyến mãi</div>
					<div class="widget-contents" style="padding-left:0px; padding-right: 0px">
						<div class="list-group" style="border-radius: 0px;">
							<a href="#" class="list-group-item" style="border-radius: 0px">Tabletes</a>
							<a href="#" class="list-group-item">Desktops</a>
							<a href="#" class="list-group-item">Software</a>
							<a href="#" class="list-group-item">Phone</a>
							<a href="#" class="list-group-item" style="border-radius: 0px">Camera</a>
						</div>
					</div>
				</div>
			</div>
     	</div>      

		<div class="col-md-8">
			<div class="page-sidebar">
				<div class="ossn-widget widget-description">
					<div class="widget-heading">Liên hệ</div>
					<div class="widget-contents">
						<div>
							<label> Họ & Tên : </label> 
							<span> Nguyễn Thịnh </span>
						</div>
						<div>
							<label> Số điện thoại : </label> 
							<span> 123456xxx </span>
						</div>
						<div>
							<label> Địa chỉ : </label> 
							<span> Phạm Văn Chiêu Phường 14 Quận Gò Vấp </span>
						</div>
						<img width="100%" src="https://www.wired.com/wp-content/uploads/2016/11/GoogleMap-1.jpg">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>