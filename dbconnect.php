
<?php
date_default_timezone_set('Asia/Tokyo');
$driver_options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"];
try{
    $db= new PDO('mysql:dbname=heroku_008028cbdf9b9d4;host=us-cdbr-east-05.cleardb.net;charset=utf8','bbefb6958d3ab1','185a1d9d',$driver_options);
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>