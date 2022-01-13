<?php
// ini_set("display_errors", 1);
// error_reporting(E_ALL);

session_start();
require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;
require 'myTokens.php';
define('CALLBACK_URL', 'https://tasktimekeeper.herokuapp.com/login/callback.php');//Twitterから認証した時に飛ぶページ場所

//login.php
//TwitterOAuthのインスタンスを生成し、Twitterからリクエストトークンを取得する
$twitter_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET);
$request_token = $twitter_connect->oauth('oauth/request_token', array('oauth_callback' => CALLBACK_URL));
 
//リクエストトークンはcallback.phpでも利用するのでセッションに保存する
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
//Twitterの認証画面へリダイレクト
$url = $twitter_connect->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
header('Location: '.$url);
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>twitter login</title>
</head>
<body>
    
</body>
</html>