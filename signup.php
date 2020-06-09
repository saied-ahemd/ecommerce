<?php
session_start();
$pageTitle='SignUp';
include "inti.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
  //get the user input
  $username=$_POST['username'];
  $email=$_POST["email"];
  $password=$_POST['password'];
  //error array
  $forErrors=[];
  //check for username
  if(isset($username)){
    
    if(empty($username)){
      $forErrors[]='the Username field can\'t be empty';
    }
    //filter the user name feild
    $filterdUser=filter_var($username,FILTER_SANITIZE_STRING);
    //check if the user name feil is less than 4 char and it's not empty to show the error
    if(strlen($filterdUser)<4 && !empty($username)){
      $forErrors[]='the user field can\'t be less that 4 charchter';
    }
    if(strlen($filterdUser)>20){
      $forErrors[]='the user field can\'t be larger that 20 charchter';
    }
  }
  if(isset($password)){
    if(empty($password)){
      $forErrors[]='the password field can\'t be empty';
    }
    if(strlen($password)<6 && !empty($password)){
      $forErrors[]='the password field should be complex and more that 6 charcher';
    }else{
      $hash=sha1($password);
    }
  }

  if(isset($email)){
    if(empty($email)){
      $forErrors[]='the Email field can\'t be empty';
    }
    $filterdEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
    if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true && !empty($email)){
      $forErrors[]='pleease enter validate Email';
    }
  }
  //if there is no error
  if(empty($formError)){
    //check if the user is already exist
   $check= checkItem("username","users",$username);
   //if the user is in the database
   if($check>0){
    $forErrors[]='this user is exist';

   }else{
        // update in database
    $stmt=$link->prepare("INSERT INTO users(username,password,Email,RegStatus,Date) VALUES(:kuser,:kpass,:kemail,0,now())");
    $stmt->execute(array(
   'kuser' => $username,
   'kpass'=>$hash,
   'kemail'=>$email,
 )
 );
 // show success message
 if($stmt->RowCount()>0){
  $succ= '<div class="alert alert-success">congrate you are Registed User You can Login </div>';
  
 }
   }
  }

}
 ?>
       <div class="errors text-center mx-auto">
         <div class="container">
           <?php 
             if(!empty($forErrors)){
               foreach($forErrors as $error){
                 echo '<div class="alert alert-danger">'.$error.'</div>';
               }
             }
             if(isset($succ)){
               echo $succ;
             }
           ?>
         </div>
       </div>
       <div class="box"> 
              <div class="image">
                <img src="images/3.png" alt="image" class="image1">
              </div>
              <div class="login">
                <h3>We Are <span>Suger</span></h3>
                <p>Welcome! Signup To Suger<br> To See New Items</p>
              <form class="text-center-sm text-center-xs form text-center" id="login-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input class="form-control input1" type="text" name="username" placeholder="userName" autocomplete="off" required="required" pattern=".{4,20}" title="UserName Must Be Between 4 & 20 char">
                <input class="form-control input1" type="email" name="email" placeholder="Email" required="required">
                <input class="form-control input2" type="password" name="password" placeholder="Password" autocomplete="new-password" required="required" minlength="6">
                <input class="btn btn-block" type="submit" value="SignUp">
              </form>
              </div>
      </div>
<?php
 include $tmp.'footer.php';
?>