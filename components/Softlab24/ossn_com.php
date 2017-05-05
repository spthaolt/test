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
define('SOFTLAB24', ossn_route()->com . 'Softlab24/');

require_once(SOFTLAB24 . 'classes/SOFTLAB24_API.php');
ossn_register_callback('ossn', 'init', 'softlab24_init');
