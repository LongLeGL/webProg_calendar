<?php
session_start();
$_SESSION['message'] = 'initialized';

// --------- test when have no login page -------
$_SESSION['userLevel'] = 'doctor';
$_SESSION['username'] = 'doctor';
$_SESSION['fullName'] = 'Nguyen Duc Thai';
// --------------------------------------------------

require_once './app/init.php';
$app = new App();

session_destroy();
$_SESSION = array();
?>