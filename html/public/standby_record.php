<?php
session_start();

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

// xss対策
require_once '../functions/security_func.php';

// データを全件取得
require '../classes/sql_logic.php';
$all_data = SqlLogic::get_table('standby_record');

// 件数を取得
$count_record = SqlLogic::count_data('standby_record');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約無し利用一覧</title>

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
.create_button{
    margin-top: 10px;
}
.nothing{
    margin-top: 100px;
}
table{
    margin-top: 10px;
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
                    <h2 class="mx-auto" style="margin-top: 15px;">予約無し利用一覧</h2>
                </div>
                <a class="create_button btn btn-primary btn-block" href="create_standby_record.php">履　歴　登　録</a>
                <br>
                <div class='row'>
                <?php while($each_data = $all_data->fetch()): ?>
                    <div class="col-md-6">
                        <table class="table table-info table-sm table-bordered">
                            <tr>
                                <th>便名</th>            
                                <td><?php echo h($each_data['flight_company']); ?><?php echo h($each_data['flight_number']); ?></td>
                            </tr>
                            <tr>
                                <th>お名前</th>            
                                <td><?php echo h($each_data['passenger_name']); ?></td>
                            </tr>
                            <tr>
                                <th>人数</th>            
                                <td><?php echo h($each_data['number_of_people']); ?></td>
                            </tr>
                            <tr>
                                <th>ご案内時間</th>            
                                <td><?php echo h($each_data['meeting_time']); ?></td>
                            </tr>
                            <tr>
                                <th>出発地</th>            
                                <td><?php echo h($each_data['meeting_place']); ?></td>
                            </tr>
                            <tr>
                                <th>お送り先</th>            
                                <td><?php echo h($each_data['destination']); ?></td>
                            </tr>
                            <tr>
                                <th>担当者</th>            
                                <td><?php echo h($each_data['person_in_charge']); ?></td>
                            </tr>
                            <tr>
                                <th></th>            
                                <td><a href="delete_standby_record.php?id=<?php echo $each_data['id']; ?>">削除</a></td>
                            </tr>
                        </table>
                    </div>
                <?php endwhile; ?>
                </div>
                <?php if($count_record === 0): ?>
                    <h6 class="nothing">声かけの徹底をお願い致します。</h6>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
</body>
</html>