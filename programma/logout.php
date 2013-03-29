<?php
session_start();
session_destroy();

// verwijder het cookie
setcookie("user", "", time()-3600);
setcookie("pwd","",time()-3600);
 
header('location:uitlezen.php');
?>