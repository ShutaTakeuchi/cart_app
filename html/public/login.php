<?php
session_start();

// ログイン判断（ログイン中であればトップページへ）
if($_SESSION['username']){
    header('Location: top.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- original css -->
<style>
.card{
    margin-top: 100px;
}
.card-top{
    margin-top: 10px;
}
</style>
</head>
<body class="login-page text-center">
    <div class="container">
        <div class="row">
            <div class="card border-white mx-auto" style="width: 17rem;">
            <div class="card-body">
            <h1 class="text-info">Cart me!</h1>
            <br>
            <!-- バリデーションの表示 -->
            <p class="text-danger"><?php echo $_SESSION['null_err']; ?></p>
            <p class="text-danger"><?php echo $_SESSION['login_err']; ?></p>

            <form action="top.php" method="post">
                <input type="text" class="user-form form-control" name="username" placeholder="ユーザ">  
                <br>      
                <input type="password" class="form-control" name="password" placeholder="パスワード"> 
                <br>  
                <input class="btn btn-info" type="submit" value="ログイン"> 
            </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// リロード後のバリデーションの表示を消す
unset($_SESSION['null_err']);
unset($_SESSION['login_err']);
?>