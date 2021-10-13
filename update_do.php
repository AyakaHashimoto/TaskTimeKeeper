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
        <p class="lead text-muted">タスクの内容を変更しました。</p>
        
        <?php
            require('dbconnect.php');
            
            if(isset($_REQUEST)&& is_numeric($_REQUEST['id'])){
                $id =$_REQUEST['id'];

            $statement = $db->prepare('UPDATE task SET task_name=?, target_time=?, created_at=?, finished_at=?, duration=? WHERE id=?');
            $statement->execute(array($_POST['task'], $_POST['target_time'], $_POST['created_at'], $_POST['finished_at'], $_POST['duration'], $id));
            } 

            $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
            $tasks->execute(array($id));
            $task =$tasks->fetch();

            $time_finished = date('H:i:s',strtotime($task['finished_at']));
        ?>   

        <div class="container my-4">
            <div class="row">
                <div class="col mt-4 ">
                <?php print($task['task_name']); ?>
                </div>

                <div class="col mt-4">
                <?php print($task['created_at']); ?>
                </div>  

                <div class="col mt-4">
                <?php print(' - '.$time_finished); ?>
                </div> 

                <div class="col mt-4">
                <?php print('目標時間: '.$task['target_time'].' 分'); ?>
                </div>  

                <div class="col mt-4">
                <?php print('かかった時間: '.$task['duration'].' 分'); ?>
                </div>  
            </div>
        </div>
        
        <p><a href="index.php" class="btn btn-outline-info">戻る</a></p>
    </main>
</body>
</html>