
<?php
date_default_timezone_set('Asia/Tokyo');
try{
    $db= new PDO('mysql:dbname=tk-db;hosts=us-cdbr-east-05.cleardb.net;charset=utf8','bbefb6958d3ab1','185a1d9d');
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>