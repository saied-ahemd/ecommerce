<?php include "inti.php"; ?>
   <div class="container">
      <h1 class="text-center">
        <?php 
          echo str_replace('-',' ',$_GET["pageName"]);
        ?>
      </h1>
      <div class="row">
      
      <?php
         $items=getItems($_GET["pageid"]);
         if($items==0){
             echo '<div class="alert alert-warning">there is no item to show</div>';
         }else{
            foreach($items as $item){
                echo "<div class='col-10 col-sm-6 col-lg-4 mx-auto my-3'>";
                   echo '<div class="card">';
                     echo '<div class="img-container">';
                        echo '<img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img">';
                        echo '<div class="card-body">';
                          echo '<div class="card-text d-flex justify-content-between text-capitalize align-items-center">'; 
                             echo '<h4>'.$item["Name"].'</h4>';
                             echo '<h4>'.$item["Price"].'</h4>';
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
 <?php include $tmp.'footer.php'; ?>
