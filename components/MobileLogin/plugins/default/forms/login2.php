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
?>
<div>
	<label><?php echo ossn_print('mobilelogin:username'); ?></label>
    <input type="text" name="username" />
</div>

<div>
	<label><?php echo ossn_print('password'); ?></label>
    <input type="password" name="password" />
</div>
<div>
	<?php echo ossn_fetch_extend_views('forms/login2/before/submit'); ?>
<div>
<div>
    <input type="submit" value="<?php echo ossn_print('site:login');?>" class="btn btn-primary"/>
    <a href="<?php echo ossn_site_url('resetlogin'); ?>"><?php echo ossn_print('reset:login'); ?> </a>
</div>
