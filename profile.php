<?php
session_start();
$pageTitle='Home';
include "inti.php";

if(isset($_SESSION["User"])){

    $stmt=$link->prepare("SELECT *  FROM users WHERE username=?");
    //ececute the Query
    $stmt->execute(array($sessionUser));
    //fetch all data (fetch get you all data in an array)=>
    $rows=$stmt->fetchAll();

?>
   <h1 class="text-center text-capitalize">My Profile</h1>
  <div class="infromation block">
      <div class="container">
      <div class="panel panel-default">
               <div class="panel-heading">
                Infromation
               </div>
               <div class="panel-body">
                   <?php
                   foreach($rows as $row){
                       
                   
                   ?>
                 Name: <?php echo $row["username"].'<br>'; ?>
                 Email: <?php  echo $row["Email"].'<br>'; ?>
                 full Name: <?php echo $row["FullName"].'<br>'; ?>
                 Date: <?php echo $row["Date"].'<br>'; ?>
                 Favourite Category: <?php echo $row["username"].'<br>'; } ?>

               </div>
           </div>
      </div>
  </div>
  
  <div class="ads block">
      <div class="container">
      <div class="panel panel-default">
               <div class="panel-heading">
                ADS
               </div>
               <div class="panel-body">
              test
               </div>

           </div>
      </div>
  </div>
  
  <div class="comments block">
      <div class="container">
      <div class="panel panel-default">
               <div class="panel-heading">
                latest comments
               </div>
               <div class="panel-body">
              rest
               </div>

           </div>
      </div>
  </div>
<?php
     }else{
         echo header("Location: login.php");
     }
 include $tmp.'footer.php';
?>