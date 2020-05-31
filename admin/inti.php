<?php
//includes
include "connect.php";
//routes
$tmp='includes/tempelates/';
$lang='includes/languages/';
$func='includes/functions/';
//include important file
//include the function file
include $func.'function.php';
 //  include $lang .'arabic.php';
include $tmp.'header.php';
//if the page has $nonavbar varable no noNvbar
if(!isset($noNavbar)){
    include $tmp.'nav.php';
}
?>
