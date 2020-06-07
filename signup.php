<?php

include "inti.php";
$pageTitle='LOGIN';
 ?>
       <div class="box"> 
              <div class="image">
                <img src="images/3.png" alt="image" class="image1">
              </div>
              <div class="login">
                <h3>We Are <span>Suger</span></h3>
                <p>Welcome! Signup To Suger<br> To See New Items</p>
              <form class="text-center-sm text-center-xs form text-center" id="login-form">
                <input class="form-control input1" type="text" name="username" placeholder="userName" autocomplete="off">
                <input class="form-control input1" type="email" name="email" placeholder="Email">
                <input class="form-control input2" type="password" name="password" placeholder="Password" autocomplete="new-password">
                <input class="btn btn-block" type="submit" value="SignUp">
              </form>
              </div>
      </div>
<?php
 include $tmp.'footer.php';
?>