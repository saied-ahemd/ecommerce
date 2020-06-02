<?php

//================================================
// == mange member page
// == you can Add|edit|delete memeber from here
// ================================================ 
ob_start();
session_start();
$pageTitle='members';
if(isset($_SESSION['username'])){
  include "inti.php";
    $do=isset($_GET['do'])?$_GET['do']:'mange';
    if($do=='mange'){//manger members page 
      //if we have page Get show the pending members
      $query='';
      if(isset($_GET["page"])=='pending'){
        $query='AND RegStatus=0';
      }
      //get all data depend on the user group id
      $stmt=$link->prepare("SELECT *  FROM Users WHERE GroupID!=1 $query");
      //ececute the Query
      $stmt->execute();
      //fetch all data (fetch get you all data in an array)=>
      $rows=$stmt->fetchAll();
      if(!empty($rows)){
    
    ?>
    <h1 class="text-center edit-title">Manger Members</h1>
        <div class="container">
           <div class="table-responsive">
              <table class="table table-bordered text-center main-table">
                <tr>
                  <td>#ID</td>
                  <td>Username</td>
                  <td>Email</td>
                  <td>Fullname</td>
                  <td>Registerd Date</td>
                  <td>control</td>
                </tr>
                <?php
                foreach($rows as $row){
                echo "<tr>";
                     echo "<td>".$row["UserID"]."</td>";
                     echo "<td>".$row["username"]."</td>";
                     echo "<td>".$row["Email"]."</td>";
                     echo "<td>".$row["FullName"]."</td>";
                     echo "<td>".$row["Date"]."</td>";
                     echo "<td>
                     <a href='members.php?do=edit&userid=".$row["UserID"]."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                     <a  href='members.php?do=delete&userid=".$row["UserID"]."' class='btn btn-danger'><i class='fa fa-close' style='position: relative;
                     top: 1px;'></i> DELETE</a>";
                     if($row["RegStatus"]==0){
                       echo "<a href='members.php?do=Activate&userid=".$row["UserID"]."' class='btn btn-primary' style='margin-left:5px'><i class='fas fa-check-circle' style='position: relative;
                       top: 1px;'></i> Activate</a>";
                     }
                   echo "</td>";
                echo "</tr>";
                }
                ?>
              </table>
           </div>
           <a href="members.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus" style="position: relative;top: 1px;"></i> New Member</a>
         </div> 
    <?php }else{
      echo '<div class="alert alert-warning mx-auto" style="margin-top:60px; text-align:center; width:600px;">there is no recorde to show</div>';
    }
    }
    elseif($do=='Add'){//Add members page
      ?>
      <!-- show the form and all data inside the inputs -->
        <h1 class="text-center edit-title">Add MEMBER</h1>
        <div class="container">
          <form class="form" action="?do=insert" method="POST">
          <!-- user name field -->
          <!-- hidden password for the s=user id -->
            <div class="form-group row ">
               <label for="username" class="control-label col-sm-2">User Name</label>
               <div class="col-sm-10 ">
                 <input type="text" name="username" class="form-control col-md-6"  required="required" placeholder="UserName" autocomplete="off">
               </div>
            </div>
            <!-- user password field -->
            <div class="form-group row">
               <label for="password" class="control-label col-sm-2">password</label>
               <div class="col-sm-10">
                 <input type="password" name="password" class="form-control col-md-6" placeholder="Password Must be hard & complex">
               </div>
            </div>
            <!-- user eamil field -->
            <div class="form-group row ">
               <label for="Email" class="control-label col-sm-2">Email</label>
               <div class="col-sm-10">
                 <input type="email" name="Email" class="form-control col-md-6"  required="required" placeholder="Email must Be Valid" autocomplete="off">
               </div>
            </div>
            <!-- full name field -->
            <div class="form-group row ">
               <label for="fullname" class="control-label col-sm-2">Full Name</label>
               <div class="col-sm-10">
                 <input type="text" name="fullname" class="form-control col-md-6"  required="required"placeholder="Full Name" autocomplete="off">
               </div>
            </div>
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="ADD" class="btn btn-primary btn-lg save">
               </div>
            </div>
        
          </form>
        </div>
     <?php }elseif($do=='insert'){//insert page
     
      if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center edit-title'>Insert MEMBER</h1>";
        echo '<div class="container">';
        //get all data from the form
        $pass=$_POST["password"];
        $hasPass=sha1($_POST["password"]);
        $user=$_POST["username"];
        $email=$_POST["Email"];
        $fullname=$_POST["fullname"];
        //validate the form
        $formError=[];
        if(strlen($user)<4){
          $formError[]= 'the user feild can not be less than <strong>4 charcters</strong>';
         }
         if(strlen($user)>20){
          $formError[]= 'the user feild can not be more than <strong>20 charcters</strong>';
         }
        if(empty($user)){
         $formError[]= 'the user feild can not be empty please enter user name';
        }
        if(empty($email)){
          $formError[]= 'the email feild can not be empty please enter your email';
         }
         if(empty($pass)){
          $formError[]= 'the password feild can not be empty please enter  password';
         }
         if(empty($fullname)){
          $formError[]= 'the full name feild can not be empty please enter your  name';
         }
         //loop into the array and show the errors
         foreach($formError as $error){
           echo '<div class="alert alert-danger"> '. $error.'</div>';
         }
         //ceck if there is no error at all then it will proceed the operation
         if(empty($formError)){
           //check if the user is already exist
          $check= checkItem("username","users",$user);
          if($check>0){
            $war= '<div class="alert alert-warning">This User Is Already Exist</div>';
            redirectHome($war,'back',5);

          }else{
            // update in database
        $stmt=$link->prepare("INSERT INTO users(username,password,Email,FullName,RegStatus,Date) VALUES(:kuser,:kpass,:kemail,:kname,1,now())");
        $stmt->execute(array(
          'kuser' => $user,
          'kpass'=>$hasPass,
          'kemail'=>$email,
          'kname'=>$fullname
        )
        );
        // show success message
        if($stmt->RowCount()>0){
          $succ= '<div class="alert alert-success">the data has been inserted successfuly</div>';
          redirectHome($succ,'back',5);
        }
          }
         }
       
      }else{
        $err="<div class='alert alert-danger'> sorry you can't browse this page directly </div>";
        //function to redirect the user to home page after 3 second
        redirectHome($err,'back',5);
      }
      echo '</div>';
     }
    elseif($do=='edit'){//edit page
      //check if the user is is_numeric number & get the integer value of it
      $userid=(isset($_GET["userid"])&& is_numeric($_GET["userid"]))? intval($_GET["userid"]): 0;
      //get all data depend on the user id
      $stmt=$link->prepare('SELECT *  FROM Users WHERE UserID=?  LIMIT 1');
      //ececute the Query
      $stmt->execute(array($userid));
      //fetch all data (fetch get you all data in an array)=>
      $row=$stmt->fetch();
      //get the rows
      $count=$stmt->rowCount();
      //ch eck if the $count of the row >0 
      if($count>0){?>
      <!-- show the form and all data inside the inputs -->
        <h1 class="text-center edit-title">EDIT MEMBER</h1>
        <div class="container">
          <form class="form" action="?do=update" method="POST">
          <!-- user name field -->
          <!-- hidden password for the s=user id -->
          <input type="hidden" name="userid" value="<?php echo $userid?>">
            <div class="form-group row ">
               <label for="username" class="control-label col-sm-2">User Name</label>
               <div class="col-sm-10 ">
                 <input type="text" name="username" class="form-control col-md-6"  required="required" value="<?php echo $row["username"]?>">
               </div>
            </div>
            <!-- user password field -->
            <div class="form-group row">
               <label for="password" class="control-label col-sm-2">password</label>
               <div class="col-sm-10">
               <input type="hidden" name="oldpassword" value="<?php echo $row["password"] ?>" >
                 <input type="password" name="newpassword" class="form-control col-md-6" placeholder="leave Blank if you don't want to change">
               </div>
            </div>
            <!-- user eamil field -->
            <div class="form-group row ">
               <label for="Email" class="control-label col-sm-2">Email</label>
               <div class="col-sm-10">
                 <input type="email" name="Email" class="form-control col-md-6"  required="required" value="<?php echo $row["Email"]?>">
               </div>
            </div>
            <!-- full name field -->
            <div class="form-group row ">
               <label for="fullname" class="control-label col-sm-2">Full Name</label>
               <div class="col-sm-10">
                 <input type="text" name="fullname" class="form-control col-md-6"  required="required" value="<?php echo $row["FullName"]?>">
               </div>
            </div>
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="SAVE" class="btn btn-success btn-lg save">
               </div>
            </div>
        
          </form>
        </div>
        <!-- if ther is no id show error message -->
      <?php }else{
        $err= "<div class='alert alert-danger'>error there is no such id </div>";
        redirectHome($err,"back",4);
      }
    }elseif($do=='update'){//update page     
      if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center edit-title'>Update MEMBER</h1>";
        echo '<div class="container">';
        //get all data from the form
        $id=$_POST["userid"];
        $user=$_POST["username"];
        $email=$_POST["Email"];
        $fullname=$_POST["fullname"];
        //password check
        //if the feild was not empty put th pass to the new password but sh1()=>not text
        $pass=empty($_POST["newpassword"])?$_POST["oldpassword"]:sha1($_POST["newpassword"]);
        //validate the form
        $formError=[];
        if(strlen($user)<4){
          $formError[]= '<div class="alert alert-danger"> the user feild can not be less than <strong>4 charcters</strong></div>';
         }
         if(strlen($user)>20){
          $formError[]= '<div class="alert alert-danger">the user feild can not be more than <strong>20 charcters</strong></div>';
         }
        if(empty($user)){
         $formError[]= '<div class="alert alert-danger">the user feild can not be empty please enter user name</div>';
        }
        if(empty($email)){
          $formError[]= '<div class="alert alert-danger">the email feild can not be empty please enter user name</div>';
         }
         if(empty($fullname)){
          $formError[]= '<div class="alert alert-danger">the full name feild can not be empty please enter user name</div>';
         }
         //loop into the array and show the errors
         foreach($formError as $error){
           echo $error.'</br>';
         }
         //ceck if there is no error at all then it will proceed the operation
         if(empty($formError)){
            // update in database
        $stmt=$link->prepare("UPDATE users SET username=?, Email =?,FullName=?,password=? WHERE UserID =?");
        $stmt->execute([$user,$email,$fullname,$pass,$id]);
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
       
      }else{
        $err= "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";
        redirectHome($err,'back',5);
      }
      echo '</div>';
    }elseif($do=='delete'){//delete members page
      //check if the user is is_numeric number & get the integer value of it
      $userid=(isset($_GET["userid"])&& is_numeric($_GET["userid"]))? intval($_GET["userid"]): 0;
      //get all data depend on the user id using itemcheck function=>
      $check= checkItem("UserID","users",$userid);
      if($check>0){
        echo "<h1 class='text-center edit-title'> DELETE MEMBER</h1>";
        echo "<div class='container'>";
        $stmt=$link->prepare('DELETE  FROM users WHERE UserID=?  LIMIT 1');
        $stmt->execute(array($userid));

        $succ= '<div class="alert alert-success">the user has been Deleted  successfuly</div>';
        redirectHome($succ,'back',3);
        
      }else{
        $err= "<div class='alert alert-danger'>this user is not't exist</div>";
        redirectHome($err,'back',5);

      }
      echo "</div>";

    }elseif($do=='Activate'){
      //Activate page
        //check if the user is is_numeric number & get the integer value of it
        $userid=(isset($_GET["userid"])&& is_numeric($_GET["userid"]))? intval($_GET["userid"]): 0;
        //get all data depend on the user id using itemcheck function=>
        $check= checkItem("UserID","users",$userid);
        if($check>0){
          echo "<h1 class='text-center edit-title'> Activate MEMBERS</h1>";
          echo "<div class='container'>";
          $stmt=$link->prepare('UPDATE users SET RegStatus=1 WHERE UserID=?');
          $stmt->execute(array($userid));
  
          $succ= '<div class="alert alert-success">the user has been Activated successfuly</div>';
          redirectHome($succ,'back',3);
          
        }else{
          $err= "<div class='alert alert-danger'>this user is not't exist</div>";
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