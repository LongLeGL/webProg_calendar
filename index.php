<?php
session_start();

// --------- test when have no login page -------
// $_SESSION['currentUser']['role'] = 'patient';
// $_SESSION['currentUser']['id'] = '1';
// $_SESSION['currentUser']['name'] = 'John Doe';
// $_SESSION['currentUser']['email'] = 'johndoe@gmail.com';

// $_SESSION['currentUser']['role'] = 'patient';
// $_SESSION['currentUser']['id'] = '2';
// $_SESSION['currentUser']['name'] = 'John Wick';
// $_SESSION['currentUser']['email'] = 'johnwick@gmail.com';

$_SESSION['currentUser']['role'] = 'patient';
$_SESSION['currentUser']['id'] = '3';
$_SESSION['currentUser']['name'] = 'John Cena';
$_SESSION['currentUser']['email'] = 'johncena@gmail.com';

// $_SESSION['currentUser']['role'] = 'doctor';
// $_SESSION['currentUser']['id'] = '4';
// $_SESSION['currentUser']['name'] = 'Hannibal Lecter';
// $_SESSION['currentUser']['email'] = 'hanniballecter@gmail.com';



if ($_SESSION['currentUser']['role'] == 'patient'){
	$_SESSION['currentUser']['doctorId'] = '4'; // instead of fixed value 4, will assign value doctorId from home view when user pick a doctor
} else {
	$_SESSION['currentUser']['doctorId'] = $_SESSION['currentUser']['id'];
}
// --------------------------------------------------

require_once './app/init.php';
$app = new App();

session_destroy();
$_SESSION = array();
?>