<?php
session_start();

if(!empty($_POST)){
	if($_POST['name']===''){
		$error['name']='blank';
		//print('nickname is blank');
	}
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
	//When no error, go to check.php
	if(empty($error)){
	$_SESSION['join'] = $_POST;
	header('Location:check.php');
	exit();
	}
}
if($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])){
	$_POST = $_SESSION['join'];
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
								<p class="error red">*パスワードを入力してください</p>
						<?php endif; ?>
				</div>
		<div class="mb-3">
			<button type="submit" class="btn btn-info">入力内容を確認する</button>
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
