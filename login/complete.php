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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>成功</h1>
    <!-- callback.phpからセッションを受け継ぐ -->
	<?php
	echo "<p>ID：".$_SESSION['id_str']."</p>";
	echo "<p>名前：". $_SESSION['name'] . "</p>";
	echo "<p>スクリーン名：". $_SESSION['screen_name'] . "</p>";
	echo "<p><img src=".$_SESSION['profile_image_url_https']."></p>";
	echo "<p>access_token：". $_SESSION['access_token']['oauth_token'] . "</p>";
	
	echo "<p><a href='../input.php'>タスク入力へ</a></p>";
	echo "<p><a href='logout.php'>ログアウト</a></p>";
	?>
</body>
</html>