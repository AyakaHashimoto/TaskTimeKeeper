
<?php
// 自動で読み込み
require ('/vendor/autoload.php');

// .envを使用する
Dotenv\Dotenv::createImmutable(__DIR__)->load();

date_default_timezone_set('Asia/Tokyo');
$driver_options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"];
try{
    $db= new PDO($_ENV['DB_CONNECT'],$driver_options);
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>