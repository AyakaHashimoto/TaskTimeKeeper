<?php
// ini_set("display_errors", 1);
// error_reporting(E_ALL);

session_start();
require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;
require 'myTokens.php';
define('CALLBACK_URL', 'http://localhost:8888/tasktimekeeper/login/callback.php');//Twitterから認証した時に飛ぶページ場所

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    //Abort! Something is wrong.  
    header("Location:logput.php");
}
//リクエストトークンを使い、アクセストークンを取得する
$twitter_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
$access_token = $twitter_connect->oauth('oauth/access_token', ['oauth_verifier' => $_REQUEST['oauth_verifier']]);

//アクセストークンからユーザの情報を取得する
$user_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$user_info = $user_connect->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);//アカウントの有効性を確認するためのエンドポイント

// $twitter = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
// $statuses = $twitter->get("search/tweets", ["q" => "TwitterOAuth"]);
//print_r($statuses);
//print_r($user_info);


//ユーザ情報が取得できればcomplete.html、それ以外はerrorに移動する
if(isset($user_info->id_str)){
    $id_str = $user_info->id_str;
    $name = $user_info->name;
    $screen_name = $user_info->screen_name;
    $profile_image_url_https = $user_info->profile_image_url_https;
    
    //各値をセッションに入れる
    $_SESSION['access_token'] = $access_token;
    $_SESSION['id_str'] = $id_str;
    $_SESSION['name'] = $name;
    $_SESSION['screen_name'] = $screen_name;
    $_SESSION['profile_image_url_https'] = $profile_image_url_https;

    //print_r($_SESSION);
 header("Location:complete.php");
 exit;
}
else{
 //header("Location:error.php");
ini_set("display_errors", 1);
error_reporting(E_ALL);

 exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>twitter callback</title>
</head>
<body>
    
</body>
</html>