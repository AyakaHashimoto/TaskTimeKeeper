<?php
// ini_set( 'display_errors', 1 );
// ini_set( 'error_reporting', E_ALL );

session_start();
require('../dbconnect.php');

header("Content-type: text/html; charset=utf-8");

// if(!isset($_SESSION['join'])){
// 	header('Location: ../input.php');
// 	exit();
// }
 
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
 
$error=[];
// var_dump($error);
// var_dump(empty($error));

if(!empty($_POST)){
	if($_POST['email']===''){
		$error['email']='blank';
	}
    elseif(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
        $error['email'] = 'format';
    }
    if(empty($error)){ //duplication check
		$membr = $db->prepare('SELECT COUNT(*) AS cnt FROM member WHERE email=?');
		$membr->execute(array($_POST['email']));
		$record = $membr->fetch();
		if($record['cnt'] > 0){
			$error['email'] = 'duplicate';
		}
	}
    if(empty($error)){
        //var_dump("No error");
        $_SESSION['email'] = $_POST['email'];
        header('Location: registration_check.php');
        exit();
        }
}
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
        <h3>メール認証</h3>
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="form-outline">
				    <label for="email" class="form-label text-muted">メールアドレス</label>
                    <input type="hidden" name="token" value="<?=$token?>">
					<input type="text" id="email" name="email" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES));?>" />
						<?php if($error['email'] === 'blank'){
							echo "<p class='error'>*メールアドレスを入力してください</p>";
                        }elseif($error['email'] === 'duplicate'){
							echo "<p class='error'>*メールアドレスが登録済みです</p>";
						}elseif($error['email'] === 'format'){
							echo "<p class='error'>*メールアドレスの形式が正しくありません</p>";
                        }?>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-outline-primary">メール送信</button>
                    </div>
				</div>
                
                </form>
            </div>
        </div>
        <a class="btn btn-outline-info mt-4" href="../index.php" role="button">最初のページへ戻る</a>

    </main>
</body>