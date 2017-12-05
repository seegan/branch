<?php
// TABLE TAKES REFRENCES FROM authentication.php IN community_auth CONFIG FILE
$config['user_role_permissions'] = array(
  'candidate' => array(
    'dashboard'         => array('index'),
    'exam'              => array('index', 'upcomming', 'expired', 'history'),
    'myauth'            => array('login', 'logout', 'recover', 'recovery_verification'),
    'exam'              => array('index', 'instruction', 'schedule'),
  ),
);
