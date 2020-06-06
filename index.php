<?php

include "inti.php";
 echo "welcom";
 $stmt=$link->prepare("SELECT * FROM users");
 $stmt->execute();
 $Users=$stmt->fetchAll();
 foreach($Users as $user){
     echo $user["username"];
     echo $user["Email"];
 }
 include $tmp.'footer.php';
?>