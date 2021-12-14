<?php
session_start();
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_SESSION['token'] != ($_SESSION['join']['token'])){
	echo "不正アクセスの可能性あり";
	exit();
}
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

if(!isset($_SESSION['join'])){
	header('Location: index.php');
	exit();
}

require('../dbconnect.php');
try{
	//例外処理
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//トランザクション開始
	$db->beginTransaction();

	if(!empty($_POST)){
		$statement =$db->prepare('INSERT INTO member SET email=?, password=?, created_at=NOW()');
		$statement->execute(array(
			$_SESSION['join']['email'],
			sha1($_SESSION['join']['password'])
		));

		//pre_memberのflagを1にする
		$statement = $db->prepare("UPDATE pre_member SET flag=1 WHERE mail=(:mail)");
		$statement->bindValue(':mail', $_SESSION['join']['email'], PDO::PARAM_STR);
		$statement->execute();

		// トランザクション完了
		$db->commit();
			
		//データベース接続切断
		$db = null;		
		
		//セッションを破棄する
		session_destroy();
		unset($_SESSION['join']);

		//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
		if (isset($_COOKIE["PHPSESSID"])) {
				setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		
		header('Location: thanks.php');
		exit();
	}
}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$db->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
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
			<p class="lead text-muted">記入した内容を確認して、「登録する」ボタンをクリックしてください</p>

			<form action="" method="post">
				<input type="hidden" name="action" value="submit" />
				<div class="form-outline mb-4">
				<label class="form-label text-muted">メールアドレス</label>
					<p>
					<?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES));
					?>
					</p>
				</div>

				<div class="form-outline mb-4">
				<label class="form-label text-muted">パスワード</label>    	
				<p>【表示されません】</p>
				</div>
		<div class="mb-3">
		 	<a href="index.php?urltoken=<?php print($_POST['urltoken']);?>">&laquo;&nbsp;書き直す</a> |
			<button type="submit" class="btn btn-info">登録する</button>
		</div>
	</form>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
</body>
</html>

 <!-- style reference https://mdbootstrap.com/docs/standard/extended/login/  -->
