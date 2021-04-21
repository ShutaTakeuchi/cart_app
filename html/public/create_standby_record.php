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
    <title>ご案内済み登録</title>

<!-- bootstrap 4.5 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<style>
/* レイアウト */
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
                    <div class="col-md-9 offset-md-3 mx-auto">
                        <h2 class="text-center" style="margin-top: 15px;">ご案内済み登録フォーム</h2>
                        <form class="text-center" action="comp_standby_record.php" method="post">
                        <br>
                        <br>
                        
                        <div class="row">
                            <div class="col">
                                <label for="flight_company">エアライン</label>
                                <select id="flight_company" class="form-control" name="flight_company">
                                    <option value="ANA">ANA</option>
                                    <option value="HD">HD</option>
                                    <option value="6J">6J</option>
                                    <option value="MQ">MQ</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="flight_number">フライト番号</label>
                                <input id="flight_number" class="form-control" type="text" name="flight_number" placeholder="111">
                            </div>
                        </div>
                        
                        <br>
                        <label for="passenger_name">お名前</label>
                        <input id="passenger_name" class="form-control" type="text" name="passenger_name" placeholder="全日空　太郎">
                        <br>
                        <label for="number_of_people">人数</label>
                        <select id="number_of_people" class="form-control" name="number_of_people">
                            <option value="1">１名</option>
                            <option value="2">２名</option>
                            <option value="3">３名</option>
                            <option value="4">４名</option>
                        </select>
                        <br>
                        <label for="meeting_time">ご案内時間</label>
                        <input id="meeting_time" class="form-control" type="time" name="meeting_time">
                        <br>
                        <label for="meeting_place">出発地</label>
                        <input id="meeting_place" class="form-control" type="text" name="meeting_place" placeholder="保安検査場A">
                        <br>
                        <label for="destination">お送り先</label>
                        <input id="destination" class="form-control" type="text" name="destination" placeholder="52ゲート">
                        <br>
                        <label for="share_staff">担当者</label>
                        <input id="share_staff" class="form-control" type="text" name="person_in_charge" placeholder="シフト責任者　◯◯">
                        <br>
                        <input type="hidden" name="share_date" value="<?php echo date('Y-m-j') ?>">
                        <input class="btn btn-primary" type="submit" value="登録">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>