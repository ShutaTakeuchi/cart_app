<?php
session_start();

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

// htmlspaecialcharsの読み込み
require_once '../functions/security_func.php';

$_SESSION['reserve_info']['status'] = $_POST['status'];
$_SESSION['reserve_info']['flight_type'] = $_POST['flight_type'];
$_SESSION['reserve_info']['flight_company'] = $_POST['flight_company'];
$_SESSION['reserve_info']['flight_number'] = $_POST['flight_number'];
$_SESSION['reserve_info']['passenger_name'] = $_POST['passenger_name'];
$_SESSION['reserve_info']['number_of_people'] = $_POST['number_of_people'];
$_SESSION['reserve_info']['meeting_time'] = $_POST['meeting_time'];
$_SESSION['reserve_info']['meeting_place'] = $_POST['meeting_place'];
$_SESSION['reserve_info']['destination'] = $_POST['destination'];
$_SESSION['reserve_info']['other_info'] = $_POST['other_info'];
$_SESSION['reserve_info']['share_staff'] = $_POST['share_staff'];
$_SESSION['reserve_info']['share_date'] = $_POST['share_date'];
$_SESSION['reserve_info']['reserve_status'] = '0';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約内容確認</title>

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
                <h2 style="margin-top: 15px;">予約フォーム確認画面</h2>
                <br>    
                <p>旅客ステータス：　<strong><?php echo h($_SESSION['reserve_info']['status']); ?></strong></p>
                
                <p>発/着：　<strong><?php echo h($_SESSION['reserve_info']['flight_type']) ;?></strong></p>
                
                <p>便名：　<strong><?php echo h($_SESSION['reserve_info']['flight_company']) ?><?php echo h($_SESSION['reserve_info']['flight_number']) ;?></strong></p>
                
                <p>お名前：　<strong><?php echo h($_SESSION['reserve_info']['passenger_name']) ;?></strong></p>
                
                <p>人数：　<strong><?php echo h($_SESSION['reserve_info']['number_of_people']) ;?></strong></p>
                
                <p>待ち合わせ時間：　<strong><?php echo h($_SESSION['reserve_info']['meeting_time']) ;?></strong></p>
                
                <p>待ち合わせ場所：　<strong><?php echo h($_SESSION['reserve_info']['meeting_place']) ;?></strong></p>
                
                <p>お送り先：　<strong><?php echo h($_SESSION['reserve_info']['destination']) ;?></strong></p>
                
                <p>その他情報：　<strong><?php echo h($_SESSION['reserve_info']['other_info']) ;?></strong></p>
                
                <p>発信者：　<strong><?php echo h($_SESSION['reserve_info']['share_staff']) ;?></strong></p>
                
                <br>

                <a class="btn btn-secondary" href="create_reserve.php">入力フォームに戻る</a>
                
                <a class="btn btn-info" href="comp_reserve.php">予約を確定する</a>
            </div>
        </div>
        
    </div>
</body>
</html>