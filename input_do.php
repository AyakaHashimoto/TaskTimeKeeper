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
        <h1 class="fw-normal">menu</h1> 
        <div class="container w-80"></div>
    </header>
  
    <main>
        <h2 class="text-center text-info my-4">TASK TIME KEEPER</h2>
        <p class="lead text-muted">Stopボタンを押すとタスクが完了し、かかった時間が登録されます。</p>
        <?php
        require('dbconnect.php');
        $statement =$db->prepare('INSERT INTO task SET task_name=?, target_time=?, member_id=?,
        created_at=NOW()');
        $statement->bindParam(1,$_POST['task'],PDO::PARAM_STR);
        $statement->bindParam(2,$_POST['target_time'],PDO::PARAM_STR);
        $statement->bindParam(3,$member['id'],PDO::PARAM_STR); //add member_id
        $statement->execute();

        //var_dump($db->lastInsertId());
        $id = $db->lastInsertId();

        $tasks = $db->prepare('SELECT * FROM task WHERE id=?');
        $tasks->execute(array($id));
        $task =$tasks->fetch();

        $created_at=date('H:i:s',strtotime($task['created_at']));

        ?>
        <br>
        
        <form id="stop" action="input_comp.php" method="post">
        <input type="hidden" name="id" value="<?php print($id); ?>">
        
            <div class="row align-items-start">
                <div class="col">
                <?php print($task['task_name']); ?>
                </div>

                <div class="col">
                <?php print("完了目標時間 : ".$task['target_time']." 分"); ?>
                </div>

                <div class="col">
                <?php print("開始時刻 : ".$created_at); ?>
                </div>

                <div class="col">
                <button class="btn btn-warning" type="submit">stop</button></label> 
                </div>
               
            </div>
        
        </form>  
        

    </main>
</body>
</html>