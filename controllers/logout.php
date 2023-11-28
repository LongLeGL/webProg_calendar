<?php 
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    setcookie("saved_user","", time()-10,"/");  //instantly expires the cookie -> remove cookie
?>