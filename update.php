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
        <div class="container w-80"></div>
    </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>
        <p class="lead text-muted">タスクの編集</p>
        
        <?php
        if(isset($_REQUEST)&& is_numeric($_REQUEST['id'])){
            $id =$_REQUEST['id'];

            $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
            $tasks->execute(array($id));
            $task =$tasks->fetch();
        }   
        ?>
        
        <form id="form" action="update_do.php" method="post">
            <input type="hidden" name="id" value="<?php print($id); ?>">
            <div class="row mb-4">
                <div class="col">
                <label for="task" class="form-label">タスク</label>
                <input type="text" id ="task" name="task" class="form-control" value="<?php print($task['task_name']); ?>">
                </div>

                <div class="col">
                <label for="target_time" class="form-label">目標時間</label>
                <input type="text" id ="target_time" name="target_time" class="form-control" value="<?php print($task['target_time']); ?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                <label for="created_at" class="form-label">開始日時</label>
                <input type="text" id ="created_at" name="created_at" class="form-control" value="<?php print($task['created_at']); ?>">
                </div>

                <div class="col">
                <label for="finished_at" class="form-label">終了日時</label>
                <input type="text" id ="finished_at" name="finished_at" class="form-control" value="<?php print($task['finished_at']); ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col">
                <label for="duration" class="form-label">かかった時間（分）</label>
                <input type="text" id ="duration" name="duration" class="form-control" value="<?php print($task['duration']); ?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                <button type="submit"  class="btn btn-outline-info">登録</button>
                </div>

                <div class="col">
                <a href="delete.php?id=<?php print($task['id']); ?>"  role="button" class="btn btn-outline-warning">削除</a>
                </div>  
            </div>
        </form>

        <div class="col mt-4 ">
        <a href="input.php" role="button" class="btn btn-outline-info">戻る</a>
        </div>
        

    </main>
</body>
</html>