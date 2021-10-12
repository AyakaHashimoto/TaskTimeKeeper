<?php require('dbconnect.php'); ?>
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
        <h1 class="fw-normal">menu</h1> 
        <div class="container w-80">内容</div>
    </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>
        <p class="lead text-muted">内容や作成者など, 以下のコレクションに関する簡単な説明文を書きましょう。なるべく短く, わかりやすい文にしましょう。しかし短すぎると, 友達は見てくれないかもしれません。</p>
        
        
        <form id="form" action="input_do.php" method="post">
            <div class="form-row">
                <div class="form-group col-4">
                <input type="text" id ="task" name="task" class="form-control" placeholder="タスク名を入力">
                </div>

                <div class="form-group col-4">
                <input type="text" id ="target_time" name="target_time" class="form-control" placeholder="目標時間を入力">
                </div>

                <div class="form-group col-4">
                <button class="btn btn-outline-info" type="submit">start</button>
                </div>
            </div>
        </form>
        <?php
        try{
        require('dbconnect.php');
        $tasks =$db->prepare('SELECT * FROM task ORDER BY id');
        $tasks->execute(array());
  
        }catch(PDOException $e){
            echo 'DB connection error: '.$e->getMessage();
        }
        ?>
        <article>
        <pre>
            <?php while($task = $tasks->fetch()):?>
            <!--<p><a href="task_edit.php?id=<?php //print($task['id']); ?>"> 
            <?php print(mb_substr($task['task'],0,50)); ?></a></p>
            <time><?php print($task['created_at']); ?></time>
            <hr>
            <?php endwhile ?>

        </pre>  
        </article>

    </main>
</body>
</html>