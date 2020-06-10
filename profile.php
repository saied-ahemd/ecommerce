<?php
session_start();
$pageTitle='MY Profile';
include "inti.php";
if(isset($_SESSION["User"])){

    $stmt=$link->prepare("SELECT *  FROM users WHERE username=?");
    //ececute the Query
    $stmt->execute(array($sessionUser));
    //fetch all data (fetch get you all data in an array)=>
    $rows=$stmt->fetch();

?>
   <h1 class="text-center text-capitalize">My Profile</h1>
  <div class="infromation block">
      <div class="container">
      <div class="panel panel-default">
               <div class="panel-heading">
                Infromation
               </div>
               <div class="panel-body">
                 Name: <?php echo $rows["username"].'<br>'; ?>
                 Email: <?php  echo $rows["Email"].'<br>'; ?>
                 full Name: <?php echo $rows["FullName"].'<br>'; ?>
                 Registered Date: <?php echo $rows["Date"].'<br>'; ?>
                 Favourite Category: <?php '<br>'; ?>

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
                   <div class="row">
                  <?php
                    $items=getItems('Member_ID',$rows["UserID"]);
                    if($items==0){
                        echo '<div class="alert alert-warning">there is no item to show <a href="newad.php">New ITEM </a></div>';
                    }else{
                       foreach($items as $item){
                           echo "<div class='col-10 col-sm-6 col-lg-4 mx-auto my-4 d-flex justify-content-between align-items-center'>";
                              echo '<div class="card">';
                                echo '<div class="img-container">';
                                   echo '<img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img">';
                                   echo '<div class="card-body">';
                                     echo '<div class="card-text d-flex justify-content-between text-capitalize align-items-center">'; 
                                     echo '<h4> <a href="deItems.php?itemid='.$item["Item_ID"].'">'.$item["Name"].'</a> </h4>';
                                        echo '<h4>'.$item["Price"].'</h4>';
                                     echo "</div>";
                                     echo '<div class="card-text d-flex justify-content-between text-capitalize align-items-center">'; 
                                        echo '<p>'.$item["Description"].'</p>';
                                     echo "</div>";
                                     echo '<div>'; 
                                        echo '<div class="date">'.$item["Add_Date"].'</div>';
                                     echo "</div>";
                                   echo "</div>";
                                echo "</div>";
                              echo "</div>";
                           echo "</div>";
                       }
           
                    }
                  
                  ?>
                  </div>
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
                  <?php
                   
                     $stmt=$link->prepare("SELECT comment  FROM comments WHERE 	user_ID =? ");
                     //ececute the Query
                     $stmt->execute(array($rows["UserID"]));
                     //fetch all data (fetch get you all data in an array)=>
                     $comments=$stmt->fetchAll();
                     if(!empty($comments)){
                         foreach($comments as $comment){
                             echo $comment["comment"].'<br>';
                         }

                     }else{
                        echo '<div>there is no comments to show</div>';
                     }
                  ?>
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