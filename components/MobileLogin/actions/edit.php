<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$entity = ossn_user_by_username(input('username'));
if(!$entity){
	redirect(REF);
}
$user['firstname'] = input('firstname');
$user['lastname'] = input('lastname');
$user['email'] = input('email');
$user['gender'] = input('gender');
$user['username'] = input('username');

$fields = ossn_user_fields_names();
foreach($fields['required'] as $field){
	$user[$field] = input($field);
}
if (!empty($user)) {
    foreach ($user as $field => $value) {
        if (empty($value)) {
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}
if(!is_numeric($user['mobilelogin'])){
            ossn_trigger_message(ossn_print('mobilelogin:invalid:mobile'), 'error');
            redirect(REF);	
} else {
	$search  = ossn_user_by_mobile($user['mobilelogin']);
	if($search && $user['mobilelogin'] !== $entity->mobilelogin){
            ossn_trigger_message(ossn_print('mobilelogin:mobile:exists'), 'error');
            redirect(REF);			
	}
}
$password = input('password');

$OssnUser = new OssnUser;
$OssnUser->password = $password;
$OssnUser->email = $user['email'];

$OssnDatabase = new OssnDatabase;
$user_get = ossn_user_by_username(input('username'));
if ($user_get->guid !== ossn_loggedin_user()->guid) {
    redirect("home");
}

$params['table'] = 'ossn_users';
$params['wheres'] = array("guid='{$user_get->guid}'");

$params['names'] = array(
    'first_name',
    'last_name',
    'email'
);
$params['values'] = array(
    $user['firstname'],
    $user['lastname'],
    $user['email']
);
//check if email is not in user
if($entity->email !== input('email')){
  if($OssnUser->isOssnEmail()){
    ossn_trigger_message(ossn_print('email:inuse'), 'error');
    redirect(REF);
  }
}
//check if email is valid email 
if(!$OssnUser->isEmail()){
    ossn_trigger_message(ossn_print('email:invalid'), 'error');
    redirect(REF);	
}
//check if password then change password
if (!empty($password)) {
    if (!$OssnUser->isPassword()) {
        ossn_trigger_message(ossn_print('password:error'), 'error');
        redirect(REF);
    }
    $salt = $OssnUser->generateSalt();
    $password = $OssnUser->generate_password($password, $salt);
    $params['names'] = array(
        'first_name',
        'last_name',
        'email',
        'password',
        'salt'
    );
    $params['values'] = array(
        $user['firstname'],
        $user['lastname'],
        $user['email'],
        $password,
        $salt
    );
}
$language = input('language');
$success  = ossn_print('user:updated');
if(!empty($language) && in_array($language, ossn_get_available_languages())){
	$lang = $language;
} else {
	$lang = 'en';
}
//save
if ($OssnDatabase->update($params)) {
    //update entities
	$user_get->data = new stdClass;
    $guid = $user_get->guid;
    if (!empty($guid)) {
		foreach($fields as $items){
				foreach($items as $field){
						$user_get->data->{$field} = $user[$field];
				}
		}
		$user_get->data->language = $lang;
        $user_get->save();
    }
    ossn_trigger_message($success, 'success');
    redirect(REF);
} 