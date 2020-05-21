<?php
$dsn ='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',

);
try{
    //try to do an object of the PDO class
    $link= new PDO($dsn,$user,$pass,$option);
    //try to find the error in exeptionmode
    $link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){

    echo "failed to connected".$e->getMessage();

}

?>