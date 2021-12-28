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
                    <a class="btn btn-outline-light mt-4" href="input.php" role="button">戻る</a>
                    <a role="button" href="login/logout.php" class="btn btn-outline-secondary">ログアウト</a>
                </div>
        </div>
 
        
        </div>
   </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>

        <p class="lead text-muted mb-4">タスク名ごとに目標時間と実際にかかった時間を表示します。</p>

        <?php
        $months =$db->prepare('SELECT DATE_FORMAT(finished_at, "%Y-%m") AS month FROM task 
        WHERE member_id=? GROUP BY DATE_FORMAT(finished_at, "%Y-%m")');
        $months->execute(array($member['id']));
        ?>
   
        <div class="container">
            
            <form class="row" action="calc_by.php" method="post">
                <div class="col-auto">
                <select class="form-select form-select-sm" name="month" aria-label=".form-select-sm month">
                    <option selected>集計する月を選ぶ</option>
                    <?php 
                     while($month = $months->fetch()){
                        $option = $month['month'];
                        echo '<option value="'.$option.'">'.$option.'</option>';
                    }
                    ?>
                </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">集計</button>
                </div>
            </form>
        </div>

        <?php
        $tasks =$db->prepare('SELECT task_name, SUM(target_time) AS tsum, SUM(duration) AS dsum FROM task WHERE member_id=? GROUP BY task_name');
        $tasks->execute(array($member['id']));

        while($task = $tasks->fetch()):
            $name = $task['task_name'];
            $tsum = $task['tsum'];
            $dsum = $task['dsum'];
        ?>

        <article>
            <div class="row">
                <div class="col">               
                    <p><a href="#"><?php print(mb_substr($name,0,50)) ?></a></p>
                </div>
                <div class="col">
                    <time><?php print('目標時間合計： '.$tsum); ?></time>
                </div>  
                <div class="col">
                    <time><?php print('かかった時間： '.$dsum); ?></time>
                </div> 
                <div class="col">
                    <time><?php print('実際-目標： '.($dsum - $tsum)); ?></time>
                </div>  
            </div>
            <hr>
            <?php endwhile; ?>  
        </article>

    </main>
</body>
</html>