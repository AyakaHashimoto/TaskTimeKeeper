<?php
session_start();

if(!isset($_SESSION['join'])){
	header('Location: index.php');
	exit();
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

			<form action="" method="post" enctype="multipart/form-data">
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
		 	<a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> |
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
