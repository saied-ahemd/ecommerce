<?php
session_start();
$pageTitle='Home';
include "inti.php";

 echo "welcom to home page ".$sessionUser;

 
 include $tmp.'footer.php';
?>