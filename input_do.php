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
        <p class="lead text-muted">Stopボタンを押すとタスクが完了し、かかった時間が登録されます。</p>
        <?php
        require('dbconnect.php');
        $statement =$db->prepare('INSERT INTO task SET task_name=?, target_time=?, created_at=NOW()');
        $statement->bindParam(1,$_POST['task'],PDO::PARAM_STR);
        $statement->bindParam(2,$_POST['target_time'],PDO::PARAM_STR);
        $statement->execute();

        //var_dump($db->lastInsertId());
        $id = $db->lastInsertId();

        $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
        $tasks->execute(array($id));
        $task =$tasks->fetch();

        $created_at=date('H:i:s',strtotime($task['created_at']));
        ?>

        <div class="container my-4">
            
            <div class="row align-items-start">
                <div class="col mt-4">
                <?php print($task['task_name']); ?>
                </div>

                <div class="col mt-4">
                <?php print("完了目標時間 : ".$task['target_time']." 分"); ?>
                </div>

                <div class="col mt-4">
                <?php print("開始時刻 : ".$created_at); ?>
                </div>

                <div class="col">
                <form id="stop" action="stop.php" method="post">
                <input type="hidden" name="id" value="<?php print($id); ?>">
                <button type="button" class="btn btn-warning">stop</button></label>
                </form>
                </div>
               
            </div>
            
        </div> 

    </main>
</body>
</html>