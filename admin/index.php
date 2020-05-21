<?php
session_start();
$noNavbar='';
$pageTitle='Login';
if(isset($_SESSION['username'])){
    header('Location:home.php');//resiract the user to the main page
}
include "inti.php";
 //check if the user come from the request method
 if($_SERVER['REQUEST_METHOD']=='POST'){
     $username=$_POST['user'];
     $password=$_POST['pass'];
     $hash=sha1($password);
     $stmt=$link->prepare('SELECT username , password, UserID FROM Users WHERE username=? AND password=? AND GroupID=1 LIMIT 1');
     $stmt->execute(array($username,$hash));
     $row=$stmt->fetch();
     $count=$stmt->rowCount();
     //if count>0 this mean the database has record to this user 
     if($count>0){
         $_SESSION['username']=$username;//register name form the form
         $_SESSION['id']=$row['UserID'];//register user id
         header('Location:home.php');//resiract the user to the main page
     }
 }
 ?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
<h4 class="text-center">Admin Login</h4>
<input type="text" name="user" placeholder="userName" autocomplete="off" class="form-control">
<input type="password" name="pass" placeholder="Password" autocomplete="new-password" class="form-control">
<input type="submit" class="btn btn-primary btn-block" value="Login">
</form>
<?php
 include $tmp.'footer.php';
?>