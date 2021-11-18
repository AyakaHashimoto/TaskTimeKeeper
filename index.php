<?php
require('../dbconnect.php');
if(!empty($_POST)){
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
            header('Location: index.php');
            exit();
        }else{
            $error['login'] = 'failed';
        }
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
								<p class="error red">*パスワードを入力してください</p>
						<?php endif; ?>
				</div>
		<div class="mb-3">
			<button type="submit" class="btn btn-outline-primary">ログイン</button>
             | <a href="/join/index.php?action=register"> 新規登録</a> |
		</div>
	</form>

</div>




    </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>
        <p class="lead text-muted">タスク名と詳細を登録しましょう。登録情報を修正するには、タスク名をクリックしてください。</p>
        

        
        <form id="form" action="input_do.php" method="post">
            <div class="row">
                <div class="col">
                <input type="text" id ="task" name="task" class="form-control" placeholder="タスク名を入力">
                </div>

                <div class="col">
                <input type="text" id ="target_time" name="target_time" class="form-control" placeholder="目標完了時間（分）を入力">
                </div>

                <div class="col">
                <button class="btn btn-outline-info" type="submit">start</button>
                </div>
            </div>
        </form>
        <br>
        <?php
        require('dbconnect.php');
        

        $tasks =$db->prepare('SELECT * FROM task ORDER BY id DESC');
        $tasks->execute(array());
        ?>
        <article>
            <?php while($task = $tasks->fetch()):
                $time_finished = date('H:i:s',strtotime($task['finished_at']));
            ?>   
            <div class="row">
                <div class="col">               
                    <p><a href="update.php?id=<?php print($task['id']); ?>"><?php print(mb_substr($task['task_name'],0,50)) ?></a></p>
                </div>
                <div class="col">
                    <time><?php print($task['created_at']); ?></time>
                </div>  
                <div class="col">
                    <time><?php print(' - '.$time_finished); ?></time>
                </div> 
                <div class="col">
                    <time><?php print('目標時間 '.$task['target_time']); ?></time>
                </div>  
                <div class="col">
                    <time><?php print('かかった時間 '.$task['duration']); ?></time>
                </div>  
            </div>
            <hr>
            <?php endwhile ?>  
        </article>
        

    </main>
</body>
</html>