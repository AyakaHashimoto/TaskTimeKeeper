<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//セッション変数を全て解除
$_SESSION = array();
 
//セッションクッキーの削除
if(ini_set('session.use_cookies')){
    $params = session_get_cookie_params();
    setcookie(session_name(). '', time()- 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']
    );
    
}

if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
}
 
session_destroy();

setcookie('email', '', time()-3600);
 
echo "<p>ログアウトしました。</p>";
 
echo "<a href='../index.php'>はじめのページへ</a>";

?>