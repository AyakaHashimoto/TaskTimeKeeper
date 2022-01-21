
<?php
// 自動で読み込み
require ('vendor/autoload.php');
date_default_timezone_set('Asia/Tokyo');

$dsn = "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME').";charset=utf8";
$user = getenv('DB_USER');
$password = getenv('DB_PASS');
$driver_options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"];
try{
    $db= new PDO($dsn,$user,$password,$driver_options);
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>