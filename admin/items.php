<?php

//================================================
// == mange member page
// == you can Add|edit|delete memeber from here
// ================================================ 
ob_start();
session_start();
$pageTitle='';
if(isset($_SESSION['username'])){
  include "inti.php";
    $do=isset($_GET['do'])?$_GET['do']:'mange';
    if($do=='mange'){
      //get all data depend on the user group id
      $stmt=$link->prepare("SELECT *  FROM items");
      //ececute the Query
      $stmt->execute();
      //fetch all data (fetch get you all data in an array)=>
      $items=$stmt->fetchAll();
      
    ?>
    <h1 class="text-center edit-title">Manger Items</h1>
        <div class="container">
           <div class="table-responsive">
              <table class="table table-bordered text-center main-table">
                <tr>
                  <td>#ID</td>
                  <td>Name</td>
                  <td>Description</td>
                  <td>Price</td>
                  <td>Adding Date</td>
                  <td>country made</td>
                  <td>control</td>
                </tr>
                <?php
                foreach($items as $item){
                echo "<tr>";
                     echo "<td>".$item["Item_ID"]."</td>";
                     echo "<td>".$item["Name"]."</td>";
                     echo "<td>".$item["Description"]."</td>";
                     echo "<td>".$item["Price"]."</td>";
                     echo "<td>".$item["Add_Date"]."</td>";
                     echo "<td>".$item["Country_Made"]."</td>";
                     echo "<td>
                     <a href='items.php?do=edit&userid=".$item["Item_ID"]."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                     <a href='#deleteModal' data-toggle='modal' class='btn btn-danger'><i class='fa fa-close' style='position: relative;
                     top: 1px;'></i> DELETE</a>";
                   echo "</td>";
                echo "</tr>";
                }
                ?>
                
              </table>
           
           </div>
           <a href="items.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus" style="position: relative;top: 1px;"></i> New items</a>
           <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-danger">
                    <h5 class="modal-title" style="color:#fff;">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="background-color: #eb6a6a">
                    <p style="color:#fff;">Delete item,Are You Sur?</p>
                  </div>
                  <div class="modal-footer bg-danger">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No,Close</button>
                    <a type="button" class="btn btn-primary" href="items.php?do=delete&userid=<?php echo $item["Item_ID"]?>">Yes,Delete</a>
                  </div>
                </div>
              </div>
           </div>
          
         </div> 
    <?php
    }elseif($do=='Add'){ ?>
    <!-- Add category page -->
    <h1 class="text-center edit-title">Add Items</h1>
        <div class="container">
          <form class="form" action="?do=insert" method="POST">
          <!-- name field -->
            <div class="form-group row ">
               <label for="name" class="control-label col-sm-2">Name</label>
               <div class="col-sm-10 ">
                 <input type="text" name="name" class="form-control col-md-6"  required="required" placeholder="Name of the Item" autocomplete="off" >
               </div>
            </div>
            <!-- Description field -->
            <div class="form-group row">
               <label for="description" class="control-label col-sm-2">Description</label>
               <div class="col-sm-10">
                 <textarea class="form-control col-md-6" rows="5" name="description" placeholder="Descripe the Category"></textarea>
               </div>
            </div>
            <!-- price field -->
            <div class="form-group row ">
               <label for="price" class="control-label col-sm-2">Price</label>
               <div class="col-sm-10">
                 <input type="text" name="price" class="form-control col-md-6"  placeholder="the Price of the item" autocomplete="off" required="required">
               </div>
            </div>
            <!-- end price feild -->
             <!-- country made  field -->
             <div class="form-group row ">
               <label for="country" class="control-label col-sm-2">country_Made</label>
               <div class="col-sm-10">
                 <input type="text" name="country" class="form-control col-md-6" placeholder="country  of made" autocomplete="off">
               </div>
            </div>
            <!-- end country made  feild -->
             <!-- Status field -->
             <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Status</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="status">
                     <option value="0">....</option>
                     <option value="1">New</option>
                     <option value="2"> Like New</option>
                     <option value="3">Used</option>
                     <option value="4">Old</option>
                 </select>
               </div>
            </div>
            <!-- end Status  feild -->
                  <!-- member field -->
                  <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Member</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="member">
                     <option value="0">....</option>
                    <?php 
                       $stmt=$link->prepare("SELECT * FROM users");
                       $stmt->execute();
                       $Users=$stmt->fetchAll();
                       foreach($Users as $user){
                           echo "<option value='".$user["UserID"]."'> ".$user["username"]." </option>";
                       }
                    ?>
                 </select>
               </div>
            </div>
            <!-- end member  feild -->
                   <!-- category field -->
                   <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Category</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="category">
                     <option value="0">....</option>
                    <?php 
                       $stmt=$link->prepare("SELECT * FROM categories");
                       $stmt->execute();
                       $Users=$stmt->fetchAll();
                       foreach($Users as $user){
                           echo "<option value='".$user["ID"]."'> ".$user["Name"]." </option>";
                       }
                    ?>
                 </select>
               </div>
            </div>
            <!-- end category  feild -->
            <!-- start submit button -->
            <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="ADD" class="btn btn-primary btn-lg save btn-sm">
               </div>
            </div>
            <!-- end submit button -->
          </form>
        </div>
   <?php }elseif($do=='insert'){
        //cha=eck if the category added from the form
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo "<h1 class='text-center edit-title'>Insert Item</h1>";
            echo '<div class="container">';
            //store the data into varibales
            $name=$_POST['name'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $country=$_POST['country'];
            $status=$_POST['status'];
            $member=$_POST["member"];
            $category=$_POST["category"];
              //validation error
              $formError=[];
              if(empty($name)){
                $formError[]= 'the Name feild can not be empty please enter item name';
              }if(strlen($name)>20){
                $formError[]= 'the name feild can not be more than<strong> 20 charcters</strong>';
              }if(empty($price)){
                $formError[]= 'the price feild can not be empty please enter item price';
              }if($status == 0){
                $formError[]= 'you should choose a status';
              }
              if($member == 0){
                $formError[]= 'you should choose a member';
              }
              if($category == 0){
                $formError[]= 'you should choose a category';
              }
              foreach($formError as $error){
                echo '<div class="alert alert-danger"> '. $error.'</div>';
              }
              if(empty($formError)){
                  //insert the data in the database
                  $stmt=$link->prepare("INSERT INTO items(Name,Description,Price,Add_Date,Country_Made,Status,Cat_ID,Member_ID) VALUES(:kname,:kdes,:kprice,now(),:kmade,:kstatus,:kcat,:kmem)");
                  $stmt->execute(array(
                    'kname' => $name,
                    'kdes'=>$description,
                    'kprice'=>$price,
                    'kmade'=>$country,
                    'kstatus'=> $status,
                    'kcat'=>$category,
                    'kmem'=>$member,
                  ));
                 // show success message
        if($stmt->RowCount()>0){
            $succ= '<div class="alert alert-success">the data has been inserted successfuly</div>';
            redirectHome($succ,'back',5);
          }
        }
    }else {
        echo '<div class="container" style="margin-top:100px;">';
        $err="<div class='alert alert-danger'> sorry you can't browse this page directly </div>";
        //function to redirect the user to home page after 5 second
        redirectHome($err,'back',5);
        echo "</div>";
    }
        echo '</div>';
    }elseif($do=='edit'){
        echo "edit Page";
    }elseif($do=='update'){
        echo "update Page";
    }elseif($do=='delete'){
        echo "delete Page";
    }elseif($do=='activate'){
        echo "activate Page";
    }
    include $tmp.'footer.php';
    
    
}else{
    header('Location:index.php');
    exit();
}
ob_end_flush();
?>