<?php
$do='';
if(isset($_GET['do'])){
    $do=$_GET['do'];

}else{
    $do='mange';
}
if($do=='mange'){
    echo "welcome you are in mange page";
    //you can delete in the href the (page.php) because you are already in the page
    echo '<a href="?do=add">Add new catigory</a>';
}elseif($do=='add'){
    echo "welcom to add page";
}elseif($do=='delete'){
    echo "welcome you are in delete page";

}else{
    echo "ther are no page like this";
}
?>