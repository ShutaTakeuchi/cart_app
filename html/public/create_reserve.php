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
    <title>予約新規登録</title>

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
                        <h2 class="text-center" style="margin-top: 15px;">新規予約フォーム</h2>
                        <form class="text-center" action="conf_reserve.php" method="post">
                        <br>
                        <div class="form-check-inline">
                            <input class="form-check-input" id="一般" type="radio" name="status" value="一般" <?php if($_SESSION['reserve_info']['status'] === '一般'){ echo 'checked';}else{ echo 'checked';} ?>>
                            <label class="form-check-label" for="一般">一般</label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" id="VIP" type="radio" name="status" value="VIP" <?php if($_SESSION['reserve_info']['status'] === 'VIP'){ echo 'checked';} ?>>
                            <label class="form-check-label" for="VIP">VIP</label>
                        </div>
                        <br>
                        <br>
                        <div class="form-check-inline">
                            <input class="form-check-input" id="出発" type="radio" name="flight_type" value="出発" <?php if($_SESSION['reserve_info']['flight_type'] === '出発'){ echo 'checked';}else{ echo 'checked';} ?>>
                            <label class="form-check-label" for="出発">出発</label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" id="到着" type="radio" name="flight_type" value="到着" <?php if($_SESSION['reserve_info']['flight_type'] === '到着'){ echo 'checked';} ?>>
                            <label class="form-check-label" for="到着">到着</label>
                        </div>
                        <br>
                        <br>

                        <div class="row">
                            <div class="col">
                                <label for="flight_company">エアライン</label>
                                <select id="flight_company" class="form-control" name="flight_company">
                                    <option value="ANA" <?php if($_SESSION['reserve_info']['flight_company'] === 'ANA'){ echo 'selected'; }?>>ANA</option>
                                    <option value="HD" <?php if($_SESSION['reserve_info']['flight_company'] === 'HD'){ echo 'selected'; }?>>HD</option>
                                    <option value="6J" <?php if($_SESSION['reserve_info']['flight_company'] === '6J'){ echo 'selected'; }?>>6J</option>
                                    <option value="MQ" <?php if($_SESSION['reserve_info']['flight_company'] === 'MQ'){ echo 'selected'; }?>>MQ</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="flight_number">フライト番号</label>
                                <input id="flight_number" class="form-control" type="text" name="flight_number" value="<?php echo $_SESSION['reserve_info']['flight_number'];?>" placeholder="111">
                            </div>
                        </div>

                        <br>
                        <label for="passenger_name">お名前</label>
                        <input id="passenger_name" class="form-control" type="text" name="passenger_name" value="<?php echo $_SESSION['reserve_info']['passenger_name']; ?>" placeholder="全日空　太郎">
                        <br>
                        <label for="number_of_people">人数</label>
                        <select id="number_of_people" class="form-control" name="number_of_people">
                            <option value="1" <?php if($_SESSION['reserve_info']['number_of_people'] === '1'){ echo 'selected'; }?>>１名</option>
                            <option value="2" <?php if($_SESSION['reserve_info']['number_of_people'] === '2'){ echo 'selected'; }?>>２名</option>
                            <option value="3" <?php if($_SESSION['reserve_info']['number_of_people'] === '3'){ echo 'selected'; }?>>３名</option>
                            <option value="4" <?php if($_SESSION['reserve_info']['number_of_people'] === '4'){ echo 'selected'; }?>>４名</option>
                        </select>
                        <br>
                        <label for="meeting_time">待ち合わせ時間</label>
                        <input id="meeting_time" class="form-control" type="time" name="meeting_time" value="<?php echo $_SESSION['reserve_info']['meeting_time']; ?>">
                        <br>
                        <label for="meeting_place">待ち合わせ場所</label>
                        <input id="meeting_place" class="form-control" type="text" name="meeting_place" value="<?php echo $_SESSION['reserve_info']['meeting_place']; ?>" placeholder="保安検査場A">
                        <br>
                        <label for="destination">お送り先</label>
                        <input id="destination" class="form-control" type="text" name="destination" value="<?php echo $_SESSION['reserve_info']['destination']; ?>" placeholder="52ゲート">
                        <br>
                        <label for="other_info">その他</label>
                        <textarea id="other_info" class="form-control" name="other_info" placeholder="男性　〜色の帽子　など"><?php echo $_SESSION['reserve_info']['other_info']; ?></textarea>
                        <br>
                        <label for="share_staff">発信者</label>
                        <input id="share_staff" class="form-control" type="text" name="share_staff" value="<?php echo $_SESSION['reserve_info']['share_staff']; ?>" placeholder="シフト責任者　◯◯">
                        <br>
                        <input type="hidden" name="share_date" value="<?php echo date('Y-m-j') ?>">
                        <input class="btn btn-primary" type="submit" value="予約確認">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>