<?php
// ini_set( 'display_errors', 1 );
// ini_set( 'error_reporting', E_ALL );

session_start();
header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

require('../dbconnect.php');

//エラーメッセージの初期化
$errors = [];

if(empty($_GET)) {
	header("Location: ../mail/registration.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET['urltoken']) ? $_GET['urltoken'] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$errors['url'] = "no_token";
	}else{
		try{
			//例外処理を投げる（スロー）ようにする
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $db->prepare("SELECT mail FROM pre_member WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();
			
			//レコード件数取得
			$row_count = $statement->rowCount();
			
			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array['mail'];
				$_SESSION['mail'] = $mail;
			}else{
				$errors['url'] = "urltoken_timeover";
			}			
		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}
}
	//データベース接続切断
	$db = null;

if(!empty($_POST)){
	if(strlen($_POST['password']) < 4){
		$errors['password']='length';
	}
	if($_POST['password']===''){
		$errors['password']='blank';
		//print('nickname is blank');
	}
	//When no error, go to check.php
	if(empty($errors)){
	$_SESSION['join'] = $_POST;
	header('Location:check.php');
	exit();
	}else{
		foreach($errors as $value){
			echo "<p>".$value."</p>";
		}
	}
}



?>



<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

 <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

	<title>会員登録</title>

</head>
<body>
<section class="vh-100" style="background: linear-gradient(45deg, #b8edf5 0%,#17a2b8 83%);">
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body text-center p-5">
		  <h3 class="text-info mb-4">会員登録</h3>
			<p class="lead text-muted"></p>

		<?php 
			if($errors['url'] === "no_token"||$errors['url'] === "urltoken_timeover"){?>
				<div class="error red">*このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。</div>
				<p>ERROR CODE: 
					<?php
					foreach($errors as $value){
						echo "<p>".$value."</p>";
					}
					?>
				</p>
				<a class="btn btn-outline-info mt-4" href="../mail/registration.php" role="button">登録ページへ戻る</a>

		<?php }else{ ?>

			<form action="" method="post">
				<div class="form-outline mb-4">
				<label class="form-label text-muted" for="email">メールアドレス</label>
					<input type="text" readonly class="form-control form-control-lg" value="<?php print(htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'));?>" />
					<input type="hidden" name="email" value="<?=$mail?>">
				</div>
				<div class="form-outline mb-4">
				<label for="password" class="form-label text-muted">パスワード</label>    	
					<input type="password" id="password" name="password" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" />
						<?php if($errors['password'] === 'length'):?>
								<p class="error">*パスワードを４文字以上で入力してください</p>
						<?php endif; ?>
						<?php if($errors['password'] === 'blank'):?>
								<p class="error red">*パスワードを入力してください</p>
						<?php endif; ?>
				</div>
				<input type="hidden" name="token" value="<?=$token?>">
				<div class="mb-3">
					<button type="submit" class="btn btn-info">入力内容を確認する</button>
				</div>
			</form>
	<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
</body>
</html>

 <!-- style reference https://mdbootstrap.com/docs/standard/extended/login/  -->
