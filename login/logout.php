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

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <title>Task Time Keeper</title>
</head>
<body>
<main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>

        <div class="card">
            <div class="card-body">
                <p class="lead mb-4">ログアウトしました。</p>
                <a class="btn btn-outline-info" href="../index.php" role="button">最初のページへ戻る</a>
            </div>
        </div>
        
    </main>
</body>