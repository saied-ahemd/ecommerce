<?php

//================================================
// == mange member page
// == you can Add|edit|delete memeber from here
// ================================================ 
ob_start();
session_start();
$pageTitle='';
if(isset($_SESSION['username'])){
  include "inti.php";
    $do=isset($_GET['do'])?$_GET['do']:'mange';
    if($do=='mange'){
        echo "mange page";
    }elseif($do=='add'){
        echo "Add Page";
    }elseif($do=='insert'){
        echo "insert Page";
    }elseif($do=='edit'){
        echo "edit Page";
    }elseif($do=='update'){
        echo "update Page";
    }elseif($do=='delete'){
        echo "delete Page";
    }elseif($do=='activate'){
        echo "activate Page";
    }
    include $tmp.'footer.php';
    
    
}else{
    header('Location:index.php');
    exit();
}
ob_end_flush();