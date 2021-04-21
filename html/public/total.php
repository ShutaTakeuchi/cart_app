<?php
session_start();

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>過去履歴検索</title>

<!-- bootstrap 4.5 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<style>
/* 画面いっぱいにする */
.container-fluid{
    padding: 0;
}
button{
    width: 100%;
    height: 100px; 
}
.image_div{
    background-image:url("../images/flight_time.png");
    background-size: 100%;
    height: 110px;
}
.cart_me{
    padding-top: 25px;
}
</style>
</head>
<body class="top-page">
    <div class="container-fluid text-center">
        <!-- ヘッダー背景 -->
        <div class="row image_div">
                <h1 class="cart_me mx-auto text-white">Cart me!</h1>
        </div>


        <div class="row">
            <!--　サイドバー -->
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='top.php'">ホーム</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='reserve.php'">E-CAR予約</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='standby_record.php'">予約無し利用</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='flight_info.php'">フライト情報</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='other_info.php'">その他情報</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='total.php'">過去履歴</button>
                <button type="button" class="btn btn-outline-info btn-lg" onclick="location.href='logout.php'">ログアウト</button>
            </div>
            <!-- メイン -->
            <div class="col-md-10">
                <div class="row">
                    <h2 class="mx-auto" style="margin-top: 15px;">過去履歴</h2>
                </div>
                <br>
                <div class="row">
                    <form class="mx-auto" action="total_show.php" method="get">
                        <div class="col">
                            <div class="form-inline">
                                <input class="form-control" id="year" type="text" name="year" value="<?php echo date('Y'); ?>" placeholder="2021">
                                <label for="year">年</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-inline">
                                <input class="form-control" id="month" type="text" name="month" value="<?php echo date('m'); ?>" placeholder="01">
                                <label for="month">月</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-inline">
                                <input class="form-control" id="day" type="text" name="day" value="<?php echo date('j'); ?>" placeholder="11">
                                <label for="day">日</label>
                            </div>
                        </div>
                        <br>
                            <input class="btn btn-info" type="submit" value="検索する">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>