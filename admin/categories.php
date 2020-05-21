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
        $stmt=$link->prepare("SELECT *  FROM categories");
        //ececute the Query
        $stmt->execute();
        //fetch all data (fetch get you all data in an array)=>
        $rows=$stmt->fetchAll();
        echo '<a href="categories.php?do=add">add page</a>';?>
        <h1 class="text-center edit-title">Manger Categories</h1>
        <div class="container category">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <i class="fa fa-calendar-alt"> Manger Categories
                   </i>
               </div>
               <div class="panel-body">
               <ul  class="list-unstyled latest-user">
                   <?php
                   foreach($rows as $row){
                       echo '<div class="cat">';
                        echo "<div class='hidden-button'>";
                           echo "<a href='#' class='btn btn-primary btn-sm ed'> <i class='fa fa-edit'></i> EDIT</a>";
                           echo "<a href='#' class='btn btn-danger btn-sm dan'> <i class='fa fa-close'></i> DELETE</a>";
                        echo "</div>";
                     
                       echo "<h3> ".$row["Name"]."</h3>";
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
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="ADD" class="btn btn-primary btn-lg save">
               </div>
            </div>
        
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
                $stmt=$link->prepare("INSERT INTO categories(Name,Description,Ordaring,Visibility,Allow_comment,Allow_ads) VALUES(:kname,:kdes,:korder,:kvisible,:kcomment,:kads)");
                $stmt->execute(array(
                  'kname' => $name,
                  'kdes'=>$description,
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
        echo "edit Page";
     }elseif($do=='update'){
        echo "update Page";
    }elseif($do=='delete'){
        echo "delete Page";
    }
    include $tmp.'footer.php';
    
}
else{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>