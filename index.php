<?php
session_start();
$pageTitle='Home';
include "inti.php";
?>
    <div class="container">
      <div class="row all">
      <?php
         $items=getAll("items",'Item_ID');
            foreach($items as $item){
                echo "<div class='col-10 col-sm-6 col-lg-3 my-3  col-md-4 cart'>";
                   echo '<div class="card">';
                     echo '<div class="img-container">';
                        echo '<img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img">';
                        echo '<div class="card-body">';
                          echo '<div class="card-text d-flex justify-content-between text-capitalize align-items-center">'; 
                             echo '<h4><a href="deItems.php?itemid='.$item["Item_ID"].'">'.$item["Name"].'</a> </h4>';
                             echo '<h4>'.$item["Price"].'</h4>';
                          echo "</div>";
                          echo '<div class="card-text d-flex justify-content-between text-capitalize align-items-center">'; 
                             echo '<p style="height:70px;">'.$item["Description"].'</p>';
                          echo "</div>";
                          echo '<div>'; 
                             echo '<div class="date">'.$item["Add_Date"].'</div>';
                          echo "</div>";
                        echo "</div>";
                     echo "</div>";
                   echo "</div>";
                echo "</div>";
            }

         
         
        
      ?>
     </div>
   </div>

 <?php
 include $tmp.'footer.php';
?>