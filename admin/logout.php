<?php
//this is how to destory the sesion and logout
session_start();//strat the session
session_unset();//unset the data
session_destroy();//destory the session
header("Location:index.php");
exit();
?>