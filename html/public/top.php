<?php
session_start();

// ログイン処理（空欄のバリデーション、認証チェック）
require_once '../classes/login_logic.php';
if($_POST){
    Login::check_data_exist($_POST['username'], $_POST['password']);
}

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

// アクセスと同時に案内が終わったかどうかを判定する（終わっている予約にはreserve_statusを1にする）
require_once '../classes/sql_logic.php';
SqlLogic::if_reserve_finished();

// 残り時間の取得
require_once '../classes/app_logic.php';

// xss対策
require_once '../functions/security_func.php';

// 次のご案内を一件取得
$next_reserve = SqlLogic::get_early_reserve('reserve')->fetch();
// フライト情報を取得
$flight_info_data = SqlLogic::get_table('flight_info')->fetch();
// その他情報を取得
$other_info_data = SqlLogic::get_table('other_info')->fetch();

// 本日の集計のデータ取得
require_once '../classes/total_logic.php';
// 件数の配列
$item = TotalItemLogic::get_item_today_total();
// 人数の配列
$number = TotalNumberLogic::get_number_today_total();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart me!</title>

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
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-4 offset-md-8">
                    <h5>お疲れさまです、<strong><?php echo $_SESSION['username']; ?></strong>さん</h5>
                    </div>
                </div>
                <div class="row">
                    <h3 class="mx-auto text-info">次のご案内</h3>
                </div>
                <div class="row">
                    <?php if($next_reserve['id']): ?>
                    <table class="table table-bordered table-info">
                        <tr>
                            <th>残り時間</th>
                            <th>待ち合わせ時間</th>
                            <th>ステータス</th>
                            <th>出発/到着</th>
                            <th>便名</th>
                            <th>お名前</th>
                            <th>人数</th>
                            <th>待ち合わせ場所</th>
                            <th>目的地</th>
                            <th>その他</th>
                        </tr>
                        <tr>
                            <td style="color: red;"><?php if($next_reserve['id']){ echo GetTime::get_timelimit($next_reserve['meeting_date'], $next_reserve['meeting_time'], $next_reserve['id']);} ?></td>
                            <td><?php echo h($next_reserve['meeting_time']); ?></td>
                            <td><?php echo h($next_reserve['passenger_status']); ?></td>
                            <td><?php echo h($next_reserve['flight_type']); ?></td>
                            <td><?php echo h($next_reserve['flight_company']); ?><?php echo $next_reserve['flight_number']; ?></td>
                            <td><?php echo h($next_reserve['passenger_name']); ?></td>
                            <td><?php echo h($next_reserve['number_of_people']); ?></td>
                            <td><?php echo h($next_reserve['meeting_place']); ?></td>
                            <td><?php echo h($next_reserve['destination']); ?></td>
                            <td><?php echo h($next_reserve['other_info']); ?></td>
                        </tr>
                    </table>
                    <?php elseif(!$next_reserve['id']): ?>
                        <p class="mx-auto">現在、予約がありません。</p>
                    <?php endif; ?>
                </div>
                <!-- 当日の集計と、flight_info, other_infoを各一つを表示する -->
                <div class="row">
                    <!-- flight_info, other_infoを表示 -->
                    <div class="col-md-6">
                        <!-- flight_info -->
                        <div class="row">
                            <div class="col-12">
                            <h3 class="mx-auto text-info">最新フライト情報</h3>
                            <?php if($flight_info_data): ?>
                            <table class="table table-info table-bordered">
                                <tr>
                                    <th>発信時間</th>            
                                    <td><?php echo h($flight_info_data['created_at']); ?></td>
                                </tr>
                                <tr>
                                    <th>便名</th>            
                                    <td><?php echo h($flight_info_data['flight_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>内容</th>            
                                    <td><?php echo h($flight_info_data['content']); ?></td>
                                </tr>
                                <tr>
                                    <th>発信者</th>            
                                    <td><?php echo h($flight_info_data['share_staff']); ?></td>
                                </tr>
                            </table>
                            </div>
                            <div class="col-12">
                            <?php else: ?>
                                <p class="mx-auto" style="margin-top: 50px;">現在、フライト情報がありません</p>
                                <br>
                            <?php endif; ?>
                            <br>
                            </div>
                        </div>
                        <!-- other_info -->
                        <div class="row">
                            <div class="col-12">
                            <h3 class="mx-auto text-info">最新その他情報</h3>
                            <?php if($other_info_data): ?>
                            <table class="table table-info table-bordered">
                                <tr>    
                                    <th>発信時間</th>            
                                    <td><?php echo h($other_info_data['created_at']); ?></td>
                                </tr>
                                <tr>    
                                    <th>内容</th>            
                                    <td><?php echo h($other_info_data['content']); ?></td>
                                </tr>
                                <tr>    
                                    <th>発信者</th>            
                                    <td><?php echo h($other_info_data['share_staff']); ?></td>
                                </tr>
                            </table>
                            </div>
                            <div class="col-12">
                            <?php else: ?>
                                <p class="mx-auto" style="margin-top: 50px;">現在、その他情報がありません</p>
                            <?php endif; ?>
                            <br>
                            </div>
                        </div>
                    </div>
                    <!-- 当日の集計を表示 -->
                    <div class="col-md-6">
                        <h3 class="text-info">本日の集計</h3>
                        <div class="card card-body border-info">
                        <h5 class="bg-light">合　　　計</h5>
                        <p><strong><?php echo $item['all']; ?></strong> 件　　<strong><?php echo $number['all']; ?></strong> 人</p>
                        <br>
                        <h5 class="bg-light">予　約　有　無　別</h5>
                        <p>予約有　:　　<?php echo $item['reserve_all']; ?> 件　　<?php echo $number['reserve_all']; ?> 人</p>
                        <p>予約無　:　　<?php echo $item['standby_record_all']; ?> 件　　<?php echo $number['standby_record_all']; ?> 人</p>
                        <br>
                        <h5 class="bg-light">旅 客 ス テ ー タ ス 別</h5>
                        <p>一　般　:　　<?php echo $item['reserve_general']; ?> 件　　<?php echo $number['reserve_general']; ?> 人</p>
                        <p>V I P　   :　　<?php echo $item['reserve_vip']; ?> 件　　<?php echo $number['reserve_vip']; ?> 人</p>
                        <br>
                        <h5 class="bg-light">キ　ャ　リ　ア　別</h5>
                        <p>A　N　A　　:　　<?php echo $item['reserve_ana'] + $item['standby_record_ana']; ?> 件　　<?php echo $number['reserve_ana'] + $number['standby_record_ana']; ?> 人</p>
                        <p>エア・ドゥ　　:　　<?php echo $item['reserve_hd'] + $item['standby_record_hd']; ?> 件　　<?php echo $number['reserve_hd'] + $number['standby_record_hd']; ?> 人</p>
                        <p>ソラシドエア　　:　　<?php echo $item['reserve_6j'] + $item['standby_record_6j']; ?> 件　　<?php echo $number['reserve_6j'] + $number['standby_record_6j']; ?> 人</p>
                        <p>スターフライヤー　　:　　<?php echo $item['reserve_mq'] + $item['standby_record_mq']; ?> 件　　<?php echo $number['reserve_mq'] + $number['standby_record_mq']; ?> 人</p>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        
    </div>
</body>
</html>