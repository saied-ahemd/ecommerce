<?php

//================================================
// == category page
// == you can Add|edit|delete category from here
// ================================================ 
ob_start();
session_start();
$pageTitle='Categories';
if(isset($_SESSION['username'])){
  include "inti.php";
    $do=isset($_GET['do'])?$_GET['do']:'mange';
    if($do=='mange'){
      //this variable sort the category depend on the ordaring 
      $sort='ASC';
      $sort_array=array("ASC","DESC");
      if(isset($_GET["sort"]) && in_array($_GET["sort"],$sort_array)){
        $sort=$_GET["sort"];
      }
        $stmt=$link->prepare("SELECT *  FROM categories ORDER BY ordaring $sort");
        //ececute the Query
        $stmt->execute();
        //fetch all data (fetch get you all data in an array)=>
        $rows=$stmt->fetchAll();
        ?>
        <h1 class="text-center edit-title">Manger Categories</h1>
        <div class="container category">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <i class="fa fa-calendar-alt"> 
                   Manger Categories
                   </i>
                   <a href="categories.php?do=add" class="btn btn-primary btn-sm" style="margin-left:15px;margin-top: -3px; float:right;"> <i class="fa fa-plus" style="position: relative;top: 1px;"></i> add Category</a>
                   <div class="sort">
                     ordering:
                      <a class="<?php if($sort=='ASC'){ echo 'active'; }?>" href="?sort=ASC">ASC</a> |
                      <a class="<?php if($sort=='DESC'){ echo 'active'; }?>" href="?sort=DESC">DESC</a>  
                   </div>
               </div>
               <div class="panel-body">
               <ul  class="list-unstyled latest-user">
                   <?php
                   foreach($rows as $row){
                       echo '<div class="cat">';
                        echo "<div class='hidden-button'>";
                           echo "<a href='?do=edit&categoryid=".$row['ID']."' class='btn btn-primary btn-sm ed'> <i class='fa fa-edit'></i> EDIT</a>";
                           echo "<a href='?do=delete&categoryid=".$row['ID']."'' class='btn btn-danger btn-sm dan'> <i class='fa fa-close'></i> DELETE</a>";
                        echo "</div>";
                     
                       echo "<h3> ".$row["Name"]."</h3>";
                       echo "<div class='full-option'>";
                       echo "<p> ";if($row["Description"]==''){
                         echo "this category has no description.";
                       }else{
                         echo $row["Description"];
                       }
                       echo "</p>";
                       if($row["Visibility"]==1){
                        echo '<span class="visibility">Hidden</span>';
                       } 
                       if($row["Allow_comment"]==1){
                        echo '<span class="commenting">Comment Disabled</span>';
                       } 
                       if($row["Allow_ads"]==1){
                        echo '<span class="ads">Ads Disabled</span>';
                       }
                       echo "</div>";
                       echo '</div>';
                       echo "<hr>";
                   }
                   ?>
                   </ul>
               </div>
           </div>
   </div>
        <?php
    }elseif($do=='add'){ ?>
        <!-- Add category page -->
        <h1 class="text-center edit-title">Add category</h1>
        <div class="container">
          <form class="form" action="?do=insert" method="POST">
          <!-- name field -->
            <div class="form-group row ">
               <label for="name" class="control-label col-sm-2">Name</label>
               <div class="col-sm-10 ">
                 <input type="text" name="name" class="form-control col-md-6"  required="required" placeholder="Name of the Category" autocomplete="off">
               </div>
            </div>
            <!-- Description field -->
            <div class="form-group row">
               <label for="description" class="control-label col-sm-2">Description</label>
               <div class="col-sm-10">
                 <textarea class="form-control col-md-6" rows="5" name="description" placeholder="Descripe the Category"></textarea>
               </div>
            </div>
            <!-- Ordring field -->
            <div class="form-group row ">
               <label for="ordring" class="control-label col-sm-2">Ordring</label>
               <div class="col-sm-10">
                 <input type="text" name="ordring" class="form-control col-md-6" placeholder="the number of the category" autocomplete="off">
               </div>
            </div>
            <!-- start visibility field -->
            <!-- start parent  -->
            <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Parent</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="parent">
                     <option value="0">....</option>
                    <?php 
                       $stmt=$link->prepare("SELECT * FROM categories WHERE parent=0");
                       $stmt->execute();
                       $cats=$stmt->fetchAll();
                       foreach($cats as $cat){
                           echo "<option value='".$cat["ID"]."'> ".$cat["Name"]." </option>";
                       }
                    ?>
                 </select>
               </div>
            </div>
            <!-- end parent -->
            <div class="form-group row ">
               <label for="visibility" class="control-label col-sm-2">Visible</label>
               <div class="col-sm-10">
                <div>
                <label for="yes">vis-yes</label>
                <input type="radio" id="yes" checked name="visibility" value="0">
                  <label for="no">vis-no</label>
                  <input type="radio" id="no" name="visibility" value="1">
                </div>
               </div>
            </div>
            <!-- end  visibility field-->
            <!-- start comment field -->
            <div class="form-group row ">
               <label for="" class="control-label col-sm-2">Comment</label>
               <div class="col-sm-10">
                <div>
                <label for="com-yes">com-yes</label>
                <input type="radio" id="com-yes" checked name="allowComment" value="0">
                  <label for="com-no">com-no</label>
                  <input type="radio" id="com-no" name="allowComment" value="1">
                </div>
               </div>
            </div>
            <!-- end  comment field-->
             <!-- start ads field -->
             <div class="form-group row ">
               <label for="" class="control-label col-sm-2">Allow Ads</label>
               <div class="col-sm-10">
                <div>
                <label for="ads-yes">ads-yes</label>
                <input type="radio" id="ads-yes" checked name="allowaAds" value="0">
                  <label for="ads-no">ads-no</label>
                  <input type="radio" id="ads-no" name="allowaAds" value="1">
                </div>
               </div>
            </div>
            <!-- end  ads field-->
             <!-- start submit button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="ADD" class="btn btn-primary btn-lg save">
               </div>
            </div>
            <!-- end submit button -->
        
          </form>
        </div>
     
        <?php 
        }elseif($do=='insert'){
        //cha=eck if the category added from the form
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo "<h1 class='text-center edit-title'>Insert Category</h1>";
            echo '<div class="container">';
            //store the data into varibales
              $name=$_POST['name'];
              $description=$_POST['description'];
              $parent=$_POST["parent"];
              $ordring=$_POST['ordring'];
              $visible=$_POST['visibility'];
              $comment=$_POST['allowComment'];
              $ads=$_POST['allowaAds'];
              //validation error
              $formError=[];
              if(empty($name)){
                $formError[]= 'the Name feild can not be empty please enter Category name';
              }if(strlen($name)>20){
                $formError[]= 'the name feild can not be more than<strong> 20 charcters</strong>';
              }
              foreach($formError as $error){
                echo '<div class="alert alert-danger"> '. $error.'</div>';
              }
              if(empty($formError)){
                $check= checkItem("Name","categories",$name);
                if($check>0){
                  $war= '<div class="alert alert-warning">This category Is Already Exist</div>';
                  redirectHome($war,'back',5);
              }else {
                  //insert the data in the database
                $stmt=$link->prepare("INSERT INTO categories(Name,Description,parent,Ordaring,Visibility,Allow_comment,Allow_ads) VALUES(:kname,:kdes,:kparent,:korder,:kvisible,:kcomment,:kads)");
                $stmt->execute(array(
                  'kname' => $name,
                  'kdes'=>$description,
                  'kparent'=>$parent,
                  'korder'=>$ordring,
                  'kvisible'=>$visible,
                  'kcomment'=>$comment,
                  'kads'=> $ads,
                ));
                 // show success message
        if($stmt->RowCount()>0){
            $succ= '<div class="alert alert-success">the data has been inserted successfuly</div>';
            redirectHome($succ,'back',5);
          }

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
      $categoryid=(isset($_GET["categoryid"])&& is_numeric($_GET["categoryid"]))? intval($_GET["categoryid"]): 0;
      //get all data depend on the user id
      $stmt=$link->prepare('SELECT *  FROM categories WHERE ID=?  LIMIT 1');
      $stmt->execute(array($categoryid));
      //fetch all data (fetch get you all data in an array)=>
      $row=$stmt->fetch();
      //get the rows
      $count=$stmt->rowCount();
      //check if the category are exist
      if($count>0){?>
       <!-- show the form and all data inside the inputs -->
       <h1 class="text-center edit-title">EDIT CATEGORY</h1>
       <div class="container">
          <form class="form" action="?do=update" method="POST">
          <!-- name field -->
          <input type="hidden" name="categoryid" value="<?php echo $categoryid?>">
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
            <!-- Ordring field -->
            <div class="form-group row ">
               <label for="ordring" class="control-label col-sm-2">Ordring</label>
               <div class="col-sm-10">
                 <input type="text" name="ordring" class="form-control col-md-6" placeholder="the number of the category" autocomplete="off" value="<?php echo $row["Ordaring"]?>">
               </div>
            </div>
            <!-- end ordraing feild -->
            <!-- start parent  -->
            <div class="form-group row ">
               <label for="Status" class="control-label col-sm-2">Parent</label>
               <div class="col-sm-10">
                 <select class=" col-md-6 select-status" name="parent">
                     <option value="0">....</option>
                    <?php 
                       $stmt=$link->prepare("SELECT * FROM categories WHERE parent=0");
                       $stmt->execute();
                       $cats=$stmt->fetchAll();
                       foreach($cats as $cat){
                           echo "<option value='".$cat["ID"]."'> ".$cat["Name"]." </option>";
                       }
                    ?>
                 </select>
               </div>
            </div>
            <!-- start visibility field -->
            <div class="form-group row ">
               <label for="visibility" class="control-label col-sm-2">Visible</label>
               <div class="col-sm-10">
                <div>
                <label for="yes">vis-yes</label>
                <input type="radio" id="yes"  name="visibility" value="0" <?php if($row["Visibility"]==0){echo 'checked';}?>>
                  <label for="no">vis-no</label>
                  <input type="radio" id="no" name="visibility" value="1" <?php if($row["Visibility"]==1){echo 'checked';}?>>
                </div>
               </div>
            </div>
            <!-- end  visibility field-->
            <!-- start comment field -->
            <div class="form-group row ">
               <label for="" class="control-label col-sm-2">Comment</label>
               <div class="col-sm-10">
                <div>
                <label for="com-yes">com-yes</label>
                <input type="radio" id="com-yes"  name="allowComment" value="0" <?php if($row["Allow_comment"]==0){echo 'checked';}?> >
                  <label for="com-no">com-no</label>
                  <input type="radio" id="com-no" name="allowComment" value="1" <?php if($row["Allow_comment"]==1){echo 'checked';}?>>
                </div>
               </div>
            </div>
            <!-- end  comment field-->
             <!-- start ads field -->
             <div class="form-group row ">
               <label for="" class="control-label col-sm-2">Allow Ads</label>
               <div class="col-sm-10">
                <div>
                <label for="ads-yes">ads-yes</label>
                <input type="radio" id="ads-yes"  name="allowaAds" value="0" <?php if($row["Allow_ads"]==0){echo 'checked';}?>>
                  <label for="ads-no">ads-no</label>
                  <input type="radio" id="ads-no" name="allowaAds" value="1" <?php if($row["Allow_ads"]==1){echo 'checked';}?>>
                </div>
               </div>
            </div>
            <!-- end  ads field-->
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="EDIT" class="btn btn-primary btn-lg save">
               </div>
            </div>
        
          </form>
        </div>
        
     <?php
      }else{
        $err= "<div class='alert alert-danger'>error there is no such id </div>";
        redirectHome($err,"back",4);
      }
     }elseif($do=='update'){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center edit-title'>Update CATEGORY</h1>";
        echo '<div class="container">';
        //get all data from the form
        $id=$_POST["categoryid"];
        $name=$_POST['name'];
        $description=$_POST['description'];
        $ordring=$_POST['ordring'];
        $parent=$_POST["parent"];
        $visible=$_POST['visibility'];
        $comment=$_POST['allowComment'];
        $ads=$_POST['allowaAds'];
        
        //validate the form
        $formError=[];
         if(strlen($name)>20){
          $formError[]= '<div class="alert alert-danger">the name feild can not be more than <strong>20 charcters</strong></div>';
         }
        if(empty($name)){
         $formError[]= '<div class="alert alert-danger">the user feild can not be empty please enter user name</div>';
        }
         //loop into the array and show the errors
         foreach($formError as $error){
           echo $error.'</br>';
         }
         if(empty($formError)){
          $check= checkItem("Name","categories",$name);
          if($check>0){
            $war= '<div class="alert alert-warning">This category Is Already Exist</div>';
            redirectHome($war,'back',5);
        }else {
          $stmt=$link->prepare("UPDATE categories  SET Name=?, Description =?,parent =?,Ordaring=?,Visibility=? ,Allow_comment=? , Allow_ads= ? WHERE ID=? ");
          $stmt->execute([$name,$description,$parent,$ordring,$visible,$comment,$ads,$id]);
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
      $categoryid=(isset($_GET["categoryid"])&& is_numeric($_GET["categoryid"]))? intval($_GET["categoryid"]): 0;
      //get all data depend on the user id using itemcheck function=>
      $check= checkItem("ID","categories",$categoryid);
      if($check>0){
        echo "<h1 class='text-center edit-title'> DELETE Category</h1>";
        echo "<div class='container'>";
        $stmt=$link->prepare('DELETE  FROM categories WHERE ID=?  LIMIT 1');
        $stmt->execute(array($categoryid));

        $succ= '<div class="alert alert-success">the category has been Deleted  successfuly</div>';
        redirectHome($succ,'back',3);
        
      }else{
        $err= "<div class='alert alert-danger'>this category is not't exist</div>";
        redirectHome($err,'back',5);
      }
      echo "</div>";
    }
    include $tmp.'footer.php';
    
}
else{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>