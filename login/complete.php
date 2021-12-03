<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

    session_start();
    require('../dbconnect.php');

	if(isset($_SESSION['id_str']) ){
		//同じTwitterIDが登録されているか確認
		$members = $db->prepare('SELECT * FROM member WHERE twitterID=?');
        $members->execute(array($_SESSION['id_str']));
        $member =$members->fetch();
		
		//登録がなければレコードを作って、改めてmemberのデータを取得
		if(empty($member)){
			$statement =$db->prepare('INSERT INTO member SET twitterID=?, created_at=NOW()');
			$statement->execute(array($_SESSION['id_str']));

			$members = $db->prepare('SELECT * FROM member WHERE twitterID=?');
			$members->execute(array($_SESSION['id_str']));
			$member =$members->fetch();	
		}

		$_SESSION['time']= time();
		$_SESSION['id']= $member['id'];

	}else{
		echo "<p>ログインに失敗しました。</p>";
		exit; 
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
        <p class="lead text-muted">ログインしました。</p>
	   <br>
		<div class="card my-4"style="width: 18rem;">
		<div class="card-body">
			<h5 class="card-title">ログイン情報</h5>
			<h6 class="card-text"><?php print($_SESSION['screen_name'].' さん'); ?></h6>
			<p><img src=<?php print($_SESSION['profile_image_url_https']);?> </p>
			<p class="card-subtitle my-2 text-muted">別のアカウントでログインする場合は、認証画面のアイコンからログアウトし、該当アカウントにログインしてください。</p>
			<a href="twitterLogin.php" class="card-link">別のアカウントでログインする</a>
		</div>
		</div>

		<div class="container my-4">
			<a class="btn btn-primary" href="../input.php" role="button">タスク入力へ</a>
		</div>
    </main>
</body>


    <!-- callback.phpからセッションを受け継ぐ
	<?php
	
	echo "<p>ID：".$_SESSION['id_str']."</p>";
	echo "<p>名前：". $_SESSION['name'] . "</p>";
	echo "<p>スクリーン名：". $_SESSION['screen_name'] . "</p>";
	echo "<p><img src=".$_SESSION['profile_image_url_https']."></p>";
	echo "<p>access_token：". $_SESSION['access_token']['oauth_token'] . "</p>";
	
	echo "<p><a href='../input.php'>タスク入力へ</a></p>";
	echo "<p><a href='logout.php'>ログアウト</a></p>";
	?> -->
