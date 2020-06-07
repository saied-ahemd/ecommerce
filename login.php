<?php
session_start();
$pageTitle='LOGIN';
if(isset($_SESSION['User'])){
    header('Location:index.php');//resiract the user to the main page
}
include "inti.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hash=sha1($password);
    $stmt=$link->prepare('SELECT username , password FROM users WHERE username=? AND password=?');
    $stmt->execute(array($username,$hash));
    $count=$stmt->rowCount();
    //if count>0 this mean the database has record to this user 
    if($count>0){
        $_SESSION['User']=$username;//register name form the form
        header('Location:index.php');//resiract the user to the main page
        exit();
    }
}
 ?>
       <div class="box"> 
              <div class="image">
                <img src="images/3.png" alt="image" class="image1">
              </div>
              <div class="login">
                <h3>We Are <span>Suger</span></h3>
                <p>Welcome Back! Log in to  Your account<br> to See New items</p>
              <form class="text-center-sm text-center-xs form text-center" id="login-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input class="form-control input1" type="text" name="username" placeholder="userName" autocomplete="off">
                <input class="form-control input2" type="password" name="password" placeholder="Password" autocomplete="new-password">
                <input class="btn btn-block" type="submit" value="Login">
              </form>
              </div>
      </div>

<?php
 include $tmp.'footer.php';
?>