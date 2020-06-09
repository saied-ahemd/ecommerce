<?php
session_start();
$pageTitle='Creat New Ad';
include "inti.php";
if(isset($_SESSION["User"])){
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        //array for all errors
        //store the data into varibales
        $filterdName=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $description= filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price=$_POST['price'];
        $country= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $status=$_POST['status'];
        $category=$_POST["category"];
          //validation error
          $formError=[];
          if(empty($filterdName)){
            $formError[]= 'the Name feild can not be empty please enter item name';
          }if(strlen($filterdName)>20){
            $formError[]= 'the name feild can not be more than<strong> 20 charcters</strong>';
          }if(strlen($filterdName)<20){
            $formError[]= 'the description feild can not be less than<strong> 10 charcters</strong>';
          }
          if(empty($price)){
            $formError[]= 'the price feild can not be empty please enter item price';
          }
          if($status == 0){
            $formError[]= 'you should choose a status';
          }
          if($category == 0){
            $formError[]= 'you should choose a category';
          }
          if(empty($formError)){
              //insert the data in the database
              $stmt=$link->prepare("INSERT INTO items(Name,Description,Price,Add_Date,Country_Made,Status,Cat_ID,Member_ID) VALUES(:kname,:kdes,:kprice,now(),:kmade,:kstatus,:kcat,:kmem)");
              $stmt->execute(array(
                'kname' => $filterdName,
                'kdes'=>$description,
                'kprice'=>$price,
                'kmade'=>$country,
                'kstatus'=> $status,
                'kcat'=>$category,
                'kmem'=>$_SESSION['uid'],
              ));
             // show success message
    if($stmt->RowCount()>0){
        $succ= '<div class="alert alert-success">the data has been inserted successfuly</div>';
      }
    }
    }

?>
   <h1 class="text-center text-capitalize">Creat New Ad</h1>
   
  <div class="infromation block">
      <div class="container">
      <div class="panel panel-default">
               <div class="panel-heading">
                Creat New Ad
               </div>
               <div class="panel-body">
                 <div class="row">
                   <div class="col-md-8">
                   <form class="form" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <!-- name field -->
                        <div class="form-group row ">
                        <label for="name" class="control-label col-sm-2">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control col-md-9 live" required="required" data-class=".live-title"   placeholder="Name of the Item" autocomplete="off" >
                        </div>
                        </div>
                        <!-- Description field -->
                        <div class="form-group row">
                        <label for="description" class="control-label col-sm-2">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control col-md-9 live" rows="5" name="description" required="required" data-class=".live-des" placeholder="Descripe the Category"></textarea>
                        </div>
                        </div>
                        <!-- price field -->
                        <div class="form-group row ">
                        <label for="price" class="control-label col-sm-2 ">Price</label>
                        <div class="col-sm-10">
                            <input type="text" name="price" class="form-control col-md-9 live" data-class=".live-price" required="required"  placeholder="the Price of the item" autocomplete="off" >
                        </div>
                        </div>
                        <!-- end price feild -->
                        <!-- country made  field -->
                        <div class="form-group row ">
                        <label for="country" class="control-label col-sm-2">country_Made</label>
                        <div class="col-sm-10">
                            <input type="text" name="country" class="form-control col-md-9" placeholder="country" required="required  of made" autocomplete="off">
                        </div>
                        </div>
                        <!-- end country made  feild -->
                        <!-- Status field -->
                        <div class="form-group row ">
                        <label for="Status" class="control-label col-sm-2">Status</label>
                        <div class="col-sm-10">
                            <select class=" col-md-9 select-status" name="status">
                                <option value="0">....</option>
                                <option value="1">New</option>
                                <option value="2"> Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                        </div>
                        <!-- end Status  feild -->
                            <!-- category field -->
                            <div class="form-group row ">
                        <label for="Status" class="control-label col-sm-2">Category</label>
                        <div class="col-sm-10">
                            <select class=" col-md-9 select-status" name="category">
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
                        <div class="save col-md-4 mx-auto">
                            <input type="submit" value="ADD ITEM" class="btn btn-primary btn-lg save btn-sm">
                        </div>
                        </div>
                        <!-- end submit button -->
                 </form> 
                 <!-- end the form -->
                   </div>
                   <!-- end the form side -->
                   <div class="col-md-4">
                   <div class="card single-item">
                    <div class="img-container">
                     <img src="images/sweets-3.jpeg" alt="sweets1" class="card-img-top store-img"> 
                    </div>
                    <div class="card-body">
                        <div class="card-text d-flex justify-content-between text-capitalize align-items-center live-prveiw">
                          <h4 class="store-item-name live-title"></h4>
                          <h5 class="store-item-price">
                            <span class="live-price" style="font-weight:bold;"></span>
                          </h5>
                        </div>
                        <div class="card-text d-flex justify-content-between text-capitalize align-items-center des-prveiw">
                          <p class="live-des">this is the description</p>
                        </div>
                    </div>
         
                  </div>
                   </div>
            <div class="errors text-center mx-auto">
                <div class="container">
                <?php 
                    if(!empty($formError)){
                    foreach($formError as $error){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    }
                    if(isset($succ)){
                    echo $succ;
                    }
                ?>
                </div>
            </div>
                 
                 </div>

               </div>
           </div>
      </div>
  </div>
  
  
<?php
     }else{
         echo header("Location: login.php");
     }
 include $tmp.'footer.php';
?>