
<?php
date_default_timezone_set('Asia/Tokyo');
try{
    $db= new PDO('mysql:dbname=tk-db;hosts=127.0.0.1;charset=utf8','ttkUser','ttkUser@app');
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>