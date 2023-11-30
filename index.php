<?php
session_start();
$_SESSION['message'] = 'initialized';

// --------- test when have no login page -------
$_SESSION['username'] = 'nmloc';
// --------------------------------------------------

require_once './app/init.php';
$app = new App();

session_destroy();
$_SESSION = array();
?>