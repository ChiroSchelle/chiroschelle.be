<?php
session_start();
echo 'naam '.$_SESSION['naam'].'<br />';
echo 'level '.$_SESSION['level'].'<br />';
echo 'afdeling '.$_SESSION['afdeling'];

?>