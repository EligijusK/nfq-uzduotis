<?php
include 'header.inc';
if(isset($_GET['LogOut']))
{
    $_SESSION['username'] = null;
    $_SESSION['administrator'] = null;
    $_SESSION['userID'] = null;
    header( "Location: ./admin-login.php");
}

?>