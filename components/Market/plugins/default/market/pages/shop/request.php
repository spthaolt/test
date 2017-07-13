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

$user = $params['user'];
$class = 'ossn-profile';
$cover = ossn_site_url('components/Market/images/fb_profile_cover.jpg');
?>
<div class="ossn-profile container">
<?php echo ossn_plugin_view('theme/page/elements/system_messages'); ?>
	<div class="row">
    	<div class="col-md-11">
			<div class="<?php echo $class; ?>">
				<div class="top-container">
					<div id="container" class="profile-cover">
						<img id="draggable" class="profile-cover-img" src="<?php echo $cover; ?>" width="100%" />
					</div>
				</div>
			</div>
			<div id="profile-hr-menu" class="profile-hr-menu" style="background-color: #fff">
				<ul id="breadcrumbs-one">
				    <li <?= ($params['step'] == 'info')?'class="active"':'' ?> ><a href="<?= SHOP_URL.'request?step=info' ?>"><?= ossn_print('shop:info:breadcrumbs') ?></a></li>
				    <li <?= ($params['step'] == 'owner')?'class="active"':'' ?> ><a href="<?= SHOP_URL.'request?step=owner' ?>"><?= ossn_print('shop:owner:breadcrumbs') ?></a></li>
				    <li <?= ($params['step'] == 'confirm')?'class="active"':'' ?> ><a href="<?= SHOP_URL.'request?step=confirm' ?>"><?= ossn_print('shop:confirm:breadcrumbs') ?></a></li>
				</ul>
			</div>  
      	</div>   
    </div>
	<div class="row ossn-profile-bottom">
        <div class="col-md-7">
			<div class="ossn-layout-module">
				<div class="module-title">
					<div class="title"><?= ossn_print('shop:request:lbl') ?></div>
					<div class="controls"></div>
				</div>
				<div class="module-contents">
					<?= $params['form'] ?>
				</div>
     		</div>
 		</div>
		<div class="col-md-4">
			<div class="ossn-layout-module">
				 sa
				 sada
				 das
				 ds   
			</div>
		</div>
	</div>
</div>