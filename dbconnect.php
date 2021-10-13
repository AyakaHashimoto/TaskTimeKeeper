
<?php
date_default_timezone_set('Asia/Tokyo');
try{
    $db= new PDO('mysql:dbname=tk-db;hots=127.0.0.1;charset=utf8','root','root');
    //echo 'success';
}catch(PDOException $e){
    echo 'DB connection error: '.$e->getMessage();
}
?>