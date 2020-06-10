<?php
session_start();
$pageTitle='show item';
include "inti.php";
 //check if the user is is_numeric number & get the integer value of it
        $itemid=(isset($_GET["itemid"])&& is_numeric($_GET["itemid"]))? intval($_GET["itemid"]): 0;
        //get all data depend on the user id
        $stmt=$link->prepare('SELECT items.*,
                                        categories.Name AS categoryName,
                                        users.username AS memberName 
                                            FROM items 
                                            INNER JOIN 
                                            categories ON categories.ID =items.Cat_ID
                                            INNER JOIN 
                                            users ON users.UserID=items.Member_ID
                                        WHERE  Item_ID=? ');
        $stmt->execute(array($itemid));
        //fetch all data (fetch get you all data in an array)=>
        $row=$stmt->fetch();
        //get the rows
        $count=$stmt->rowCount();
        if($count>0){


?>
        <h1 class="text-center text-capitalize"><?php echo $row["Name"]?></h1>

        <div class="container" >
        <!-- start row one  -->
            <div class="row" style="margin-bottom:120px;margin-top:30px">
            <div class="col-md-3"> 
                <img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img img-thumbnail">
                <div class="date"><?php echo $row["Add_Date"]?></div>
            </div>
            <div class="col-md-9">
                    <h2><?php echo $row["Name"]?></h2>
                    <p><?php echo $row["Description"]?></p>
                    <h4> Price: <?php echo $row["Price"]?></h4>
                    <h5>Made in: <?php echo $row["Country_Made"]?></h5>
                    <h5>Added By:  <?php echo $row["memberName"]?></h5>
                    <h5>Category Name:<a href="categories.php?pageid=<?php echo $row["Cat_ID"]?> "> <?php echo $row["categoryName"]?> </a></h5>

            </div>
            </div>
            <!-- end roe one  -->
            <hr>
            <!-- start comment feild -->
            <?php
             if(isset($_SESSION["User"])){ ?>

            <!-- start add comment feild -->
            <div class="row">
              <div class="offset-3 col-md-3">
                <div class="add-comment">
                    <h4>Add Comment</h4>
                    <form action="<?php echo $_SERVER['PHP_SELF'] .'?itemid='.$row["Item_ID"]?>" method="POST">
                    <textarea name="comment"></textarea>
                    <input type="submit" class="btn btn-primary" value="Add Comment">
                    </form>
                    <?php
                      if($_SERVER["REQUEST_METHOD"]=='POST')
                      {
                          $comment=filter_var($_POST["comment"],FILTER_SANITIZE_STRING);
                          $user=$_SESSION['uid'];
                          $itemid=$row["Item_ID"];
                          if(!empty($comment))
                          {
                            $stmt=$link->prepare("INSERT INTO comments(comment,status,comment_date,item_id,user_ID) VALUES(:kname,0,now(),:kcat,:kmem)");
                            $stmt->execute(array(
                              'kname' => $comment,
                              'kcat'=>$itemid,
                              'kmem'=>$user,
                            ));
                        }
                    }
                    
                    ?>
                </div>
              </div>
            
            </div>
            <hr>
            <!-- end add comment feild -->
            <?php }else
            {
                 echo "<a href='login.php'>Login</a>";
            }
            ?>
            <div class="container" style="margin-top:90px">
            <h3 class="text-center">Comments on <?php echo $row["Name"] ?></h3>
            <?php
                     $stmt=$link->prepare("SELECT comments.*,users.username AS user  FROM comments
                     INNER JOIN users ON users.UserID =comments.user_ID 
                     WHERE item_id =? AND status=1
                     ORDER BY comment_ID DESC
                   ");
                   //ececute the Query
                   $stmt->execute(array($itemid));
                   //fetch all data (fetch get you all data in an array)=>
                   $comments=$stmt->fetchAll();
                   
                  ?>
            <?php 
                    foreach($comments as $comment){ ?>
                       <div class="comment-box">
                       <div class="row">
                          <div class="col-sm-1">
                          <img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img  rounded-circle">
                               <?php  ?> 
                            </div>
                          <div class="col-md-11">
                              <?php
                              echo '<div class="comment">';
                          echo '<div style="font-weight: bold;">'.$comment["user"].'</div>';
                          echo $comment["comment"];
                          echo '</div>'; 
                          
                          ?> </div>
                          
                        </div>
                        <hr>
                       </div>
                   <?php } ?>
                    
            
            </div>
             <!-- end  comment feild -->
        </div>
<?php
 }
    else{
        $err= "<div class='alert alert-danger'>error there is no such id </div>";
        redirectHome($err,"back",3);
    }
include $tmp.'footer.php';
?>