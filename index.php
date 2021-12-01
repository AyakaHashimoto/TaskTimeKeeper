<?php
//ini_set( 'display_errors', 1 );
//ini_set( 'error_reporting', E_ALL );
session_start();
require('dbconnect.php');

if($_COOKIE['email'] !== '' && $_POST['email'] ===''){
    $_POST['email'] = $_COOKIE['email'];//$_POST bc session<-post
}
if(!empty($_POST)){
    $email = $_POST['email']; //if email imput, ignore cookie
	if($_POST['email']===''){
		$error['email']='blank';
		//print('nickname is blank');
	}
	if(strlen($_POST['password']) < 4){
		$error['password']='length';
	}
	if($_POST['password']===''){
		$error['password']='blank';
		//print('nickname is blank');
	}
    if(empty($error)){
		$login = $db->prepare('SELECT * FROM member WHERE email=? AND password=?');
		$login->execute(array(
            $_POST['email'], 
            sha1($_POST['password'])
        ));
		$member = $login->fetch();
        if($member){
            $_SESSION['id'] =$member['id'];
            $_SESSION['time']= time();

            if($_POST['loginCheck'] === 'on'){
                setcookie('email', $_POST['email'], time()+60*60*24*14);
            }

            header('Location: index.php');
            exit();
        }else{
            $error['login'] = 'failed';
        }
    }
    if(!$_SESSION && empty($error)){ //to use session data for login only contents
        $_SESSION['join'] = $_POST;
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
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <title>Task Time Keeper</title>
</head>
<body>
    <header>
        <h1 class="fw-normal">TaskTimeKeeper</h1> 
        <div class="container w-80">
        <p class="lead text-muted">タスクの開始から完了までの時間を記録し、一覧と集計ができるアプリです。仕事の工数管理や勉強時間の記録に。</p>
        </div>

    
        <div class="container py-5">
		  <h1 class="text-left mb-4">ログイン</h1>
			<p class="lead text-muted"></p>

			<form action="" method="post">
				<div class="form-outline mb-4">
				<label class="form-label text-muted" for="email">メールアドレス</label>
					<input type="text" id = "email" name="email" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES));?>" />
						<?php if($error['email'] === 'blank'):?>
							<div class="error red">*メールアドレスを入力してください</div>
						<?php endif; ?>
				</div>

				<div class="form-outline mb-4">
				<label for="password" class="form-label text-muted">パスワード</label>    	
					<input type="password" id="password" name="password" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" />
						<?php if($error['password'] === 'length'):?>
								<p class="error">*パスワードを４文字以上で入力してください</p>
						<?php endif; ?>
						<?php if($error['password'] === 'blank'):?>
								<p class="error">*パスワードを入力してください</p>
						<?php endif; ?>
				</div>
                <?php if($error['login'] === 'failed'):?>
								<p class="error">*ログインに失敗しました</p>
				<?php endif; ?>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="on" id="loginCheck" name="loginCheck">
                    <label class="form-check-label text-primary" for="loginCheck">
                    次回から自動的にログインする
                    </label>
                </div>
                <br>
                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-primary">ログイン</button>
                    | <a href="/tasktimekeeper/join/index.php?action=register"> 新規登録</a> |
                    <button class="btn btn-outline-primary my-2" href="login/twitterLogin.php">
                    Twitterでログイン</button>
                </div>
	        </form>
        
        </div>
   </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>

        <?php 
        session_start();
        if(!(isset($_SESSION['id']))|| !($_SESSION['time'] + 10800 > time())){
        ?>
        <p class="lead text-muted mb-4">左カラムのログインフォームからログイン、または新規ユーザ登録をして下さい。</p>
        <p>テストユーザで試す場合は以下でログインしてください。</p>
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">テストユーザメールアドレス</li>
            <li class="list-group-item">example@mail</li>
            <li class="list-group-item active">テストユーザパスワード</li>
            <li class="list-group-item">1234</li>
        </ul>
        
        <?php }else{ 
            header('Location: input.php');
            exit();
        
         } ?>

    </main>
</body>
</html>