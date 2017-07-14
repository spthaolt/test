<?php
define('__POST_PHOTOS__', ossn_route()->com . 'PostPhotos/');
require_once(__POST_PHOTOS__ . 'classes/UploadHandler.php');

//
function postphotos_init() {

	//
	ossn_register_page('postphotos', 'postphotos_pages_handler');

	//
	ossn_new_external_css('blueimp-gallery.css', 'components/PostPhotos/plugins/default/css/blueimp-gallery.min.css');
	ossn_new_external_css('fileupload-ui.css', 'components/PostPhotos/plugins/default/css/jquery.fileupload-ui.css');
	ossn_new_external_css('fileupload.css', 'components/PostPhotos/plugins/default/css/jquery.fileupload.css');
	ossn_new_external_css('circle.css', 'components/PostPhotos/plugins/default/css/circle.css');
	
	ossn_load_external_css('blueimp-gallery.css');
	ossn_load_external_css('fileupload-ui.css');
	ossn_load_external_css('fileupload.css');
	ossn_load_external_css('circle.css');

	ossn_new_external_js('widget','components/PostPhotos/plugins/default/js/vendor/jquery.ui.widget.js');
	ossn_new_external_js('load-image','components/PostPhotos/plugins/default/js/load-image.all.min.js');
	ossn_new_external_js('canvas','components/PostPhotos/plugins/default/js/canvas-to-blob.min.js');
	ossn_new_external_js('transport','components/PostPhotos/plugins/default/js/jquery.iframe-transport.js');
	ossn_new_external_js('fileupload','components/PostPhotos/plugins/default/js/jquery.fileupload.js');
	ossn_new_external_js('process','components/PostPhotos/plugins/default/js/jquery.fileupload-process.js');
	ossn_new_external_js('image','components/PostPhotos/plugins/default/js/jquery.fileupload-image.js');
	ossn_new_external_js('audio','components/PostPhotos/plugins/default/js/jquery.fileupload-audio.js');
	ossn_new_external_js('video','components/PostPhotos/plugins/default/js/jquery.fileupload-video.js');
	ossn_new_external_js('validate','components/PostPhotos/plugins/default/js/jquery.fileupload-validate.js');
	ossn_new_external_js('ui','components/PostPhotos/plugins/default/js/jquery.fileupload-ui.js');
	ossn_new_external_js('progress-circle','components/PostPhotos/plugins/default/js/progress-circle.js');

	ossn_load_external_js('widget');
	ossn_load_external_js('load-image');
	ossn_load_external_js('canvas');
	ossn_load_external_js('transport');
	ossn_load_external_js('fileupload');
	ossn_load_external_js('process');
	ossn_load_external_js('image');
	ossn_load_external_js('audio');
	ossn_load_external_js('video');
	ossn_load_external_js('validate');
	ossn_load_external_js('progress-circle');
	//ossn_load_external_js('ui');

	ossn_extend_view('js/opensource.socialnetwork', 'js/postphotos');
}

//
function postphotos_pages_handler($pages) {
		$page = $pages[0];

		if(empty($page)) {
				return false;
		}
		switch($page) {
			case 'upload':
				$upload_dir = ossn_get_userdata("files/");

				$upload_handler = new UploadHandler(array(
					'upload_dir' => $upload_dir,
					'max_file_size' => 5242880, //5MB file size
					'image_file_types' => '/\.(gif|jpe?g|png)$/i',
				));

				break;
			case 'delete':	

					if (!is_null($pages[1]) && !empty($pages[1])) {

						unlink(ossn_get_userdata("files/".$pages[1]));
						unlink(ossn_get_userdata("files/thumbnail/".$pages[1]));
					}

				break;
			default:

				ossn_error_page();
				break;
						
		}
}

ossn_register_callback('ossn', 'init', 'postphotos_init');