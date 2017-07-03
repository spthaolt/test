<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
function multi_upload_init(){
	ossn_extend_view('css/ossn.default', 'multiupload/css');
	
	ossn_new_external_js('dropzone', 'components/MultiUpload/vendors/dropzone/dropzone.min.js');
	ossn_load_external_js('dropzone');
}
ossn_register_callback('ossn', 'init', 'multi_upload_init');
