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
        <p class="lead text-muted">タスクを完了しました</p>
        
        <?php
        require('dbconnect.php');
        
        $id = $_POST['id'];

        $datetimeNow = new DateTime(); //cuurent time as 'finished_at'
        $stopTime = $datetimeNow->format('Y-m-d H:i:s');

        $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
        $tasks->execute(array($id));
        $task =$tasks->fetch();

        $startTime = DateTime::createFromFormat('Y-m-d H:i:s', $task['created_at'])->format('Y-m-d H:i:s');
        $duration = (strtotime($stopTime) - strtotime($startTime))/60;
        var_dump($id);
        var_dump($duration); //float(2.05) 
        var_dump($datetimeNow);//object(DateTime)#2 (3) { ["date"]=> string(26) "2021-10-17 21:19:38.266596" ["timezone_type"]=> int(3) ["timezone"]=> string(10) "Asia/Tokyo" } 
        var_dump($stopTime);//string(19) "2021-10-17 21:19:38"

        $dur ='100';
        $stopT =new DateTime();

        require('dbconnect.php');
        $statement = $db->prepare('UPDATE task SET task_name=?, target_time=?,  WHERE id=?');
        $statement->execute(array($dur, $id));

        // $statement->bindParam(1,$dur,PDO::PARAM_STR);
        // $statement->bindParam(2,$stopT,PDO::PARAM_STR);
        // $statement->execute();

        // $statement = $db->prepare('INSERT INTO task SET duration=? WHERE id=?');
        // $statement->execute(array($duration, $id));

        // $statement = $db->prepare('UPDATE task SET finished_at=? WHERE id=?');
        // $statement->execute(array($stopTime, $id));
        
        ?>
    <!-- <?php
        // try{
        //     $stmt = $db->prepare('INSERT INTO task SET duration=? WHERE id=?');
        //     $stmt->execute(array($duration, $id));
        // }catch(PDOException $e){
        //     echo 'DB error: '.$e->getMessage();
        //   }
    ?> -->

        <div class="container my-4">
            <div class="row">
                <div class="col mt-4 ">
                <?php print($task['task_name']); ?>
                </div>

                <div class="col mt-4">
                <?php print($task['created_at']); ?>
                </div>  

                <div class="col mt-4">
                <?php print(' - '.$stopTime); ?>
                </div> 

                <div class="col mt-4">
                <?php print('目標時間: '.$task['target_time'].' 分'); ?>
                </div>  

                <div class="col mt-4">
                <?php print('かかった時間: '.$duration.' 分'); ?>
                </div>  
            </div>
        </div>
 
        <br>

        <p><a href="index.php" class="btn btn-outline-info">戻る</a></p>
        

    </main>
</body>
</html>