<?php
/**
 * @package        permissions.php
 * @subpackage     MyApp
 * @author         Anirudh K. Mahant
 * @created        09/05/2016 - 9:30 PM
 * @license        Creative Commons 3.0 Attribution
 * @licenseurl    https://creativecommons.org/licenses/by/3.0/us/
 * @desc           User Permissions Configuration
 * @link           https://www.ravendevelopers.com
 */

// TABLE TAKES REFRENCES FROM authentication.php IN community_auth CONFIG FILE
$config['user_role_permissions'] = array(
  'admin' => array(
    'dashboard'     => array('index'),
    'plugins'       => array('index', 'config'),
    'user'         => array('index', 'add', 'edit', 'delete'),
    'role'          => array('index', 'add', 'edit', 'delete'),
  ),
  'candidate' => array(
    'dashboard'         => array('index'),
    'exam'              => array('index', 'upcomming', 'expired', 'history'),
    'orders'            => array('index', 'add'), // Removed 'edit', 'remove' actions
    'myauth'            => array('login', 'logout', 'recover', 'recovery_verification'),
  )
);
