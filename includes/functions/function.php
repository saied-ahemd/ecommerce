<?php
// this function get all the data in the table you choose
function getAll($name,$order=NULL){
    if($order==NULL){
        $query='';
    }else{
        $query='ORDER BY '.$order.' DESC';
    }
    global $link;
    $getAll=$link->prepare("SELECT * FROM `$name` WHERE Approve=1 $query ");
    $getAll->execute(array());
    $rows=$getAll->fetchAll();
    return $rows;

}

// this function get the categories
function getCAt($where=NULL){
    $sql=$where == NULL ? '':$where; 
    global $link;
    $cat=$link->prepare("SELECT * FROM `categories` $sql ORDER BY `Ordaring` ASC");
    $cat->execute(array());
    $rows=$cat->fetchAll();
    if(!empty($rows)){
        return $rows;
    }else{
        return 0;
    }
}
//this function get the all items
function getItems($where,$value,$approve=NULL){

    global $link;
    if($approve == NULL){
        $query='AND Approve = 1';
    }else{
        $query=NULL;
    }
    $item=$link->prepare("SELECT * FROM `items` WHERE $where=? $query ORDER BY `Item_ID` DESC");
    $item->execute(array($value));
    $rows=$item->fetchAll();
    if(!empty($rows)){
        return $rows;
    }else{
        return 0;
    }
}
//function to check activate pepole
function checkReg($user){
    global $link;
    $stmt=$link->prepare('SELECT username , RegStatus FROM users WHERE username=? AND 	RegStatus=0');
    $stmt->execute(array($user));
    $count=$stmt->rowCount();
    return $count;

}

////////////////////////////////////////////////////////////////////////
// function that echo the page title if the page has
// $pageTitle variable v1.0
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo 'DEfault';
    }
    
}
// redirct function to the home page [take to par 1-the message[error ,danger,warning] 2-seconds 3-url]=> v2.0
function redirectHome($errmes, $url=null,$sec=3){
    if($url==null){
        $url='home.php';
        $direct='HomePage';
    }else{
       if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"]!==''){
        $url=$_SERVER["HTTP_REFERER"];
        $direct='Previous Page';
       }else{
           $url='home.php';
           $direct='HomePage';
       }
    }
    echo  $errmes;
    echo "<div class='alert alert-info'> You Will Redirected to the $direct After $sec Seconds </div>";
    header("Refresh:$sec;url=$url");
    exit(); 
    
}
/*
**check item v1.0
**this function check if anything exsied in the database or not and take paremeters [$select,$tablename,$value=?]
**$select=> the item to select=>[username,item]
**$tablename=>the table that i will check from=>[users,items]
**$value=> the value of the select => [saied,box].
*/
function checkItem($select,$tableName,$valueToEcecute){
    global $link;
    $stmt=$link->prepare("SELECT $select FROM $tableName WHERE $select=?");
    $stmt->execute(array($valueToEcecute));
    $count=$stmt->rowCount();
    return $count;
}
/**
 * Item Count v1.0
 * function to calaulate the number of the row inside the database
 * $itemName is the item that you want to count
 * $tableName the name of the table you want to get the data from
 */
function itemCount($itemName,$tableName){
    global $link;
    $count=$link->prepare("SELECT COUNT($itemName) FROM $tableName");
    $count->execute();
    return $count->fetchColumn();
}
/**
 * Item Count with spesefic search v1.0
 * function to calaulate the number of the row inside the database depend on the search thing
 * $itemName is the item that you want to count
 * $tableName the name of the table you want to get the data from
 * $spesific search the value that you want to search about ex=>RegStatus=1 or 0
 */
function itemCountPrivate($itemName,$tableName,$value){
    global $link;
    $stmt2=$link->prepare("SELECT $itemName FROM $tableName WHERE $itemName=?");
    $stmt2->execute(array($value));
    $count=$stmt2->rowCount();
    return $count;

}
/** latest function get the latest items or users or comments in the database
 * $select to select the feild 
 * $tableName the name of the table that you want to get the data from
 * $limit the number of the data that you want and by default it's 5
 * $order the feild that you will depand on to order the data =>userID,itemID,commentID;
 */
function getLatest($select,$table,$order,$limit=5){
    global $link;
    $latest=$link->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $latest->execute(array());
    $rows=$latest->fetchAll();
    return $rows;
}