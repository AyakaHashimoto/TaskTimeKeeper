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
        <p class="lead text-muted">タスクの編集</p>
        
        <?php
        $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
        $tasks->execute(array(17));
        $task =$tasks->fetch();
        ?>
        
        <form id="form" action="update_do.php" method="post">
            <textarea name="task" cols="50" rows ="10"><?php print($task['task_name']); ?></textarea><br>
            <button type="submit">登録</button>
        </form>


        

    </main>
</body>
</html>