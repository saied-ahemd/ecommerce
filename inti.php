<?php
//includes
include "admin/connect.php";
$sessionUser='';
if(isset($_SESSION['User'])){
    $sessionUser=$_SESSION['User'];
}
$sessionID='';
if(isset($_SESSION['uid'])){
    $sessionID=$_SESSION['uid'];
}
//routes
$tmp='includes/tempelates/';
$lang='includes/languages/';
$func='includes/functions/';
//include important file
//include the function file
include $func.'function.php';
 //  include $lang .'arabic.php';
include $tmp.'header.php';
?>
