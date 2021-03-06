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
        <p class="lead text-muted">タスクを削除しました。</p>
        
        <?php
            require('dbconnect.php');
        if(isset($_REQUEST['id'])&& is_numeric($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $statement = $db->prepare('DELETE FROM task WHERE id=?');
            $statement->execute(array($id));
        }
        ?>   
        <div class="col mt-4 ">
        <a href="input.php" role="button" class="btn btn-outline-info">戻る</a>
        </div>
    </main>
</body>
</html>