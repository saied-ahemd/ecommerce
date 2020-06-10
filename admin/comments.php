<?php

//================================================
// == mange comment page
// == you can |edit|delete| Approve comment from here
// ================================================ 
ob_start();
session_start();
$pageTitle='comments';
if(isset($_SESSION['username'])){
  include "inti.php";
    $do=isset($_GET['do'])?$_GET['do']:'mange';
    if($do=='mange'){//manger comment page 
      
    
      //get all data depend on the user group id
      $stmt=$link->prepare("SELECT comments.*,items.Name AS itemsName,users.username AS user  FROM comments
        INNER JOIN items ON items.Item_ID=comments.item_id 
        INNER JOIN users ON users.UserID =comments.user_ID 
      ");
      //ececute the Query
      $stmt->execute();
      //fetch all data (fetch get you all data in an array)=>
      $comments=$stmt->fetchAll();
      
    
    ?>
    <h1 class="text-center edit-title">Manger comments</h1>
        <div class="container">
           <div class="table-responsive">
              <table class="table table-bordered text-center main-table">
                <tr>
                  <td>ID</td>
                  <td>comment</td>
                  <td>Item Name</td>
                  <td>User Name</td>
                  <td>Added Date</td>
                  <td>control</td>
                </tr>
                <?php
                foreach($comments as $comment){
                echo "<tr>";
                     echo "<td>".$comment["comment_ID"]."</td>";
                     echo "<td>".$comment["comment"]."</td>";
                     echo "<td>".$comment["itemsName"]."</td>";
                     echo "<td>".$comment["user"]."</td>";
                     echo "<td>".$comment["comment_date"]."</td>";
                     echo "<td>
                     <a href='comments.php?do=edit&commentid=".$comment["comment_ID"]."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                     <a  href='comments.php?do=delete&commentid=".$comment["comment_ID"]."' class='btn btn-danger'><i class='fa fa-close' style='position: relative;
                     top: 1px;'></i> DELETE</a>";
                     if($comment["status"]==0){
                       echo "<a href='comments.php?do=Approve&commentid=".$comment["comment_ID"]."' class='btn btn-primary' style='margin-left:5px'><i class='fas fa-check-circle' style='position: relative;
                       top: 1px;'></i> Approve</a>";
                     }
                   echo "</td>";
                echo "</tr>";
                }
                ?>
              </table>
           </div>
         </div> 
            <?php }
    elseif($do=='edit'){//edit page
      //check if the user is is_numeric number & get the integer value of it
      $commentid=(isset($_GET["commentid"])&& is_numeric($_GET["commentid"]))? intval($_GET["commentid"]): 0;
      //get all data depend on the user id
      $stmt=$link->prepare('SELECT *  FROM comments WHERE 	comment_ID=?  LIMIT 1');
      //ececute the Query
      $stmt->execute(array($commentid));
      //fetch all data (fetch get you all data in an array)=>
      $row=$stmt->fetch();
      //get the rows
      $count=$stmt->rowCount();
      //ch eck if the $count of the row >0 
      if($count>0){?>
      <!-- show the form and all data inside the inputs -->
        <h1 class="text-center edit-title">EDIT Comment</h1>
        <div class="container">
          <form class="form" action="?do=update" method="POST">
          <!-- user name field -->
          <!-- hidden password for the s=user id -->
          <input type="hidden" name="commentid" value="<?php echo $commentid?>">
            <div class="form-group row ">
               <label for="Comment" class="control-label col-sm-2">Comment</label>
               <div class="col-sm-10 ">
                 <input type="text" name="Comment" class="form-control col-md-6"  required="required" value="<?php echo $row["comment"]?>">
               </div>
            </div>
             <!-- start button -->
             <div class="form-group row">
               <div class="save col-md-7">
                 <input type="submit" value="UPDATE" class="btn btn-success btn-lg save">
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
        $id=$_POST["commentid"];
        $comment=$_POST["Comment"];
        

        $formError=[];
        if(empty($comment)){
         $formError[]= '<div class="alert alert-danger">the comment feild can not be empty please enter comment</div>';
        }
         //loop into the array and show the errors
         foreach($formError as $error){
            echo '<div class="alert alert-danger">'.$error.'</div>';
         }
         //ceck if there is no error at all then it will proceed the operation
         if(empty($formError)){
            // update in database
        $stmt=$link->prepare("UPDATE comments SET comment=?  WHERE comment_ID=?");
        $stmt->execute([$comment,$id]);
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
      $commentid=(isset($_GET["commentid"])&& is_numeric($_GET["commentid"]))? intval($_GET["commentid"]): 0;
      //get all data depend on the user id using itemcheck function=>
      $check= checkItem("comment_ID","comments",$commentid);
      if($check>0){
        echo "<h1 class='text-center edit-title'> DELETE Comment</h1>";
        echo "<div class='container'>";
        $stmt=$link->prepare('DELETE  FROM comments WHERE comment_ID=?  LIMIT 1');
        $stmt->execute(array($commentid));

        $succ= '<div class="alert alert-success">the Comment has been Deleted successfuly</div>';
        redirectHome($succ,'back',3);
        
      }else{
        $err= "<div class='alert alert-danger'>this comment is not't exist</div>";
        redirectHome($err,'back',5);

      }
      echo "</div>";

    }elseif($do=='Approve'){
      //Activate page
        //check if the user is is_numeric number & get the integer value of it
        $commentid=(isset($_GET["commentid"])&& is_numeric($_GET["commentid"]))? intval($_GET["commentid"]): 0;
        //get all data depend on the user id using itemcheck function=>
        $check= checkItem("comment_ID","comments",$commentid);
        if($check>0){
          echo "<h1 class='text-center edit-title'> APPROVE COMMENT</h1>";
          echo "<div class='container'>";
          $stmt=$link->prepare('UPDATE comments SET status=1 WHERE comment_ID=?');
          $stmt->execute(array($commentid));
  
          $succ= '<div class="alert alert-success">the comment has been Approved successfuly</div>';
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