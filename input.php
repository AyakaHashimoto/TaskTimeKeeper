<?php
    session_start();
    require('dbconnect.php');

    if(isset($_SESSION['id'])&& $_SESSION['time'] + 10800 > time()){
        $_SESSION['time']= time();

        $members = $db->prepare('SELECT * FROM member WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member =$members->fetch();

    }else{
        header('Location: index.php');
        exit();
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

                <!-- ログイン中に表示するもの -->
        <div class="container">
                <div class="d-grid gap-2 mx-auto">
                    <a class="btn btn-outline-light mt-4" href="calc.php" role="button">タスク集計ページ</a>
                    <a class="btn btn-outline-secondary" href="login/logout.php" role="button">ログアウト</a>
                </div>
        </div>
 
        
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
        $tasks =$db->prepare('SELECT * FROM task WHERE member_id=? ORDER BY id DESC');
        $tasks->execute(array($member['id']));
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
                    <time><?php print('目標時間 '.$task['target_time'].' 分'); ?></time>
                </div>  
                <div class="col">
                    <time><?php print('かかった時間 '.$task['duration'].' 分'); ?></time>
                </div>  
            </div>
            <hr>
            <?php endwhile ?>  
        </article>

    </main>
</body>
</html>