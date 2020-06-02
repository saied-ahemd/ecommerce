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
      //get the not Approve people
      $approve='';
      if(isset($_GET["approve"])=='denied'){
        $approve='AND Approve=0';
      }
      //get all data depend on the user group id
      $stmt=$link->prepare("SELECT items.*,categories.Name AS category_name,users.username AS member_name FROM items
      INNER JOIN categories ON categories.ID=items.Cat_ID
      INNER JOIN users ON users.UserID=items.Member_ID $approve");
      //ececute the Query
      $stmt->execute();
      //fetch all data (fetch get you all data in an array)=>
      $items=$stmt->fetchAll();
      if(!empty($items)){
      
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
                  <td>category name</td>
                  <td>member name</td>
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
                     echo "<td>".$item["category_name"]."</td>";
                     echo "<td>".$item["member_name"]."</td>";
                     echo "<td>
                     <a href='items.php?do=edit&itemid=".$item["Item_ID"]."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                     <a href='items.php?do=delete&itemid=".$item["Item_ID"]."'  class='btn btn-danger'><i class='fa fa-close' style='position: relative;
                     top: 1px;'></i> DELETE</a>";
                     if($item["Approve"]==0){
                      echo "<a href='items.php?do=Approve&itemid=".$item["Item_ID"]."' class='btn btn-primary' style='margin-left:5px'><i class='fas fa-check-circle' style='position: relative;
                      top: 1px;'></i> Approve </a>";
                    }
                   echo "</td>";
                echo "</tr>";
                }
                ?>
              </table>
           </div>
           <a href="items.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus" style="position: relative;top: 1px;"></i> New items</a>
         </div> 
    <?php }else{
      echo '<div class="alert alert-warning mx-auto" style="margin-top:60px; text-align:center; width:600px;">there is no recorde to show</div>';
    }
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
        //check if the user is is_numeric number & get the integer value of it
      $itemid=(isset($_GET["itemid"])&& is_numeric($_GET["itemid"]))? intval($_GET["itemid"]): 0;
      //get all data depend on the user id
      $stmt=$link->prepare('SELECT *  FROM items WHERE  Item_ID=? ');
      $stmt->execute(array($itemid));
      //fetch all data (fetch get you all data in an array)=>
      $row=$stmt->fetch();
      //get the rows
      $count=$stmt->rowCount();
      //check if the category are exist
      if($count>0){?>
       <!-- show the form and all data inside the inputs -->
       <h1 class="text-center edit-title">EDIT Item</h1>
       <div class="container">
          <form class="form" action="?do=update" method="POST">
          <!-- name field -->
          <input type="hidden" name="itemid" value="<?php echo $itemid?>">
            <div class="form-group row ">
               <label for="name" class="control-label col-sm-2">Name</label>
               <div class="col-sm-10 ">
                 <input type="text" name="name" class="form-control col-md-6"  required="required" placeholder="Name of the Category" autocomplete="off" value="<?php echo $row["Name"]?>">
               </div>
            </div>
            <!-- Description field -->
            <div class="form-group row">
               <label for="description" class="control-label col-sm-2">Description</label>
               <div class="col-sm-10">
                 <textarea class="form-control col-md-6" rows="5" name="description" placeholder="Descripe the Category">
                 <?php echo $row["Description"]?>
                 </textarea>
               </div>
            </div>
             <!-- price field -->
             <div class="form-group row ">
               <label for="price" class="control-label col-sm-2">Price</label>
               <div class="col-sm-10">
                 <input type="text" name="price" value="<?php echo $row["Price"]?>" class="form-control col-md-6"  placeholder="the Price of the item" autocomplete="off" required="required">
               </div>
            </div>
            <!-- end price feild -->
             <!-- country made  field -->
             <div class="form-group row ">
               <label for="country" class="control-label col-sm-2">country_Made</label>
               <div class="col-sm-10">
                 <input type="text" name="country"  value="<?php echo $row["Country_Made"]?>" class="form-control col-md-6" placeholder="country  of made" autocomplete="off">
               </div>
            </div>
            <!-- end country made  feild -->
             <!-- Status field -->
             <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Status</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="status">
                     <option value="0">....</option>
                     <option value="1"  <?php if($row["Status"]==1){echo "selected";}?>>New</option>
                     <option value="2" <?php if($row["Status"]==2){echo "selected";}?>> Like New</option>
                     <option value="3" <?php if($row["Status"]==3){echo "selected";}?>>Used</option>
                     <option value="4" <?php if($row["Status"]==4){echo "selected";}?>>Old</option>
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
                           echo "<option value='".$user["UserID"]."'";
                           if($row["Member_ID"]==$user["UserID"]){
                            echo "selected";
                           }
                           echo "> ".$user["username"]." </option>";
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
                           echo "<option value='".$user["ID"]."'";
                           if($row["Cat_ID"]==$user["ID"]){
                            echo "selected";
                           }
                           echo "> ".$user["Name"]." </option>";
                       }
                    ?>
                 </select>
               </div>
            </div>
            <!-- end category  feild -->
            
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="EDIT" class="btn btn-primary btn-lg save">
               </div>
            </div>
            <!-- end button -->
        
          </form>
        </div>
        
     <?php
      }else{
        $err= "<div class='alert alert-danger'>error there is no such id </div>";
        redirectHome($err,"back",4);
      }
    }elseif($do=='update'){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center edit-title'>Update Items</h1>";
        echo '<div class="container">';
        //get all data from the form
        $id=$_POST["itemid"];
        $name=$_POST['name'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $country=$_POST['country'];
        $status=$_POST['status'];
        $category=$_POST["category"];
        $member=$_POST["member"];
        //validate the form
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
         //loop into the array and show the errors
         foreach($formError as $error){
           echo '<div class="alert alert-danger">'.$error.'</div>';
         }
         if(empty($formError)){
          $stmt=$link->prepare("UPDATE items  SET Name=?, Description =?,Price=?,Country_Made=? ,Status=? , Cat_ID= ?,Member_ID =? WHERE Item_ID =? ");
          $stmt->execute([$name,$description,$price,$country,$status,$category,$member,$id]);
          // show success message
          if($stmt->RowCount()>0){
            $succ='<div class="alert alert-success">the data has been updated successfuly</div>';
            redirectHome($succ,'back',3);
          }else{
            $err= '<div class="alert alert-warning">the data not changed at all please check your data and try agin</div>';
            //redirect the user to the add page to change the data
            redirectHome($err,'back',5);
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
    }elseif($do=='delete'){
        //delete category page
      //check if the user is is_numeric number & get the integer value of it
      $itemid=(isset($_GET["itemid"])&& is_numeric($_GET["itemid"]))? intval($_GET["itemid"]): 0;
      //get all data depend on the user id using itemcheck function=>
      $check= checkItem("Item_ID","items",$itemid);
      if($check>0){
        echo "<h1 class='text-center edit-title'> DELETE Items</h1>";
        echo "<div class='container'>";
        $stmt=$link->prepare('DELETE  FROM items WHERE Item_ID=?');
        $stmt->execute(array($itemid));

        $succ= '<div class="alert alert-success">the item has been Deleted successfuly</div>';
        redirectHome($succ,'back',3);
        
      }else{
        $err= "<div class='alert alert-danger'>this item is not't exist</div>";
        redirectHome($err,'back',5);
      }
      echo "</div>";
    }elseif($do=='Approve'){
        //approve page
        //check if the user is is_numeric number & get the integer value of it
        $itemid=(isset($_GET["itemid"])&& is_numeric($_GET["itemid"]))? intval($_GET["itemid"]): 0;
        //get all data depend on the user id using itemcheck function=>
        $check= checkItem("Item_ID","items",$itemid);
        if($check>0){
          echo "<h1 class='text-center edit-title'> Activate MEMBERS</h1>";
          echo "<div class='container'>";
          $stmt=$link->prepare('UPDATE items SET Approve=1 WHERE 	Item_ID =?');
          $stmt->execute(array($itemid));
  
          $succ= '<div class="alert alert-success">the item has been Approved successfuly</div>';
          redirectHome($succ,'back',3);
          
        }else{
          $err= "<div class='alert alert-danger'>this item is not't exist</div>";
          redirectHome($err,'back',5);
  
        }
        echo "</div>";
    }
    include $tmp.'footer.php';
    
    
}else{
    header('Location:index.php');
    exit();
}
ob_end_flush();
?>