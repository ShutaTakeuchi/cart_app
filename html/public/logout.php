<?php
session_start();

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

// ログアウト処理
$_SESSION = [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    .card{
        margin-top: 100px;
    }
    .card-top{
        margin-top: 10px;
    }
    </style>
</head>
<body class="text-center">
    <div class="container">
        <div class="row">
            <div class="card border-white mx-auto" style="width: 30rem;">
                <div class="card-body mx-auto">
                <h1 class="text-info">Bye!</h1>
                <br>
                <p>ログアウトしました。</p>
                <p>引き続きよろしくお願いします。</p>
                <a class="btn btn-info" href="login.php">ログイン</a>
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>