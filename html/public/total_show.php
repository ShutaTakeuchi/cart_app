<?php
session_start();

// ログイン判定
if(!$_SESSION['username']){
    header('Location: login.php');
    exit;   
}

// データの取得
require_once '../classes/sql_logic.php';
// xss対策
require_once '../functions/security_func.php';
// getで送られた日時合体する処理
$selected_date = $_GET['year']. '-'. $_GET['month']. '-'. $_GET['day'];
// 予約データと予約無しデータを取得
$reserve_data = SqlLogic::get_selected_table('reserve', $selected_date);
$non_reserve_data = SqlLogic::get_selected_table('standby_record', $selected_date);

// 予約有りと予約無しそれぞれのカウントを取得する
$count_reserve = SqlLogic::count_history_data('reserve', $selected_date);
$count_non_reserve = SqlLogic::count_history_data('standby_record', $selected_date);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>過去履歴検索一覧</title>

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
.nothing{
    margin-top: 50px;
    margin-bottom: 50px;
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
                                <input class="form-control" id="year" type="text" name="year" value="<?php echo $_GET['year']; ?>" placeholder="2021">
                                <label for="year">年</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-inline">
                                <input class="form-control" id="month" type="text" name="month" value="<?php echo $_GET['month']; ?>" placeholder="01">
                                <label for="month">月</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-inline">
                                <input class="form-control" id="day" type="text" name="day" value="<?php echo $_GET['day']; ?>" placeholder="11">
                                <label for="day">日</label>
                            </div>
                        </div>
                        <br>
                            <input class="btn btn-info" type="submit" value="検索する">
                        
                    </form>
                </div>

                <br>
                <br>

                <!-- 予約有りの一覧表示 -->
                <div class="row">
                    <h2 class="mx-auto">予約有り</h2>
                </div>

                <div class="row">
                    <?php while($each_data = $reserve_data->fetch()): ?>
                    <div class=col-md-6>
                        <table class="table table-info table-sm table-bordered">
                            <tr>
                                <th>時間</th>
                                <td><?php echo h($each_data['meeting_time']); ?></td>
                            </tr>
                            <tr>
                                <th>ステータス</th>
                                <td><?php echo h($each_data['passenger_status']); ?></td>
                            </tr>
                            <tr>
                                <th>出発/到着</th>
                                <td><?php echo h($each_data['flight_type']); ?></td>
                            </tr>
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
                                <th>待ち合わせ場所</th>
                                <td><?php echo h($each_data['meeting_place']); ?></td>
                            </tr>
                            <tr>
                                <th>目的地</th>
                                <td><?php echo h($each_data['destination']); ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><a href="edit_reserve.php?id=<?php echo $each_data['id']; ?>">編集</a></td>
                            </tr>
                        </table>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php if($count_reserve === 0): ?>
                        <h6 class=nothing>この日は予約利用がありません。</h6>
                <?php endif; ?>

                <hr>

                <!-- 予約無しの一覧表示 -->
                <div class="row">
                    <h2 class="mx-auto">予約無し</h2>
                </div>

                <div class="row">
                    <?php while($each_data = $non_reserve_data->fetch()): ?>
                    <div class=col-md-6>
                        <table class="table table-info table-sm table-bordered">
                            <tr>
                                <th>時間</th>
                                <td><?php echo h($each_data['meeting_time']); ?></td>
                            </tr>
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
                                <th>待ち合わせ場所</th>
                                <td><?php echo h($each_data['meeting_place']); ?></td>
                            </tr>
                            <tr>
                                <th>目的地</th>
                                <td><?php echo h($each_data['destination']); ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><a href="edit_reserve.php?id=<?php echo $each_data['id']; ?>">編集</a></td>
                            </tr>
                        </table>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php if($count_non_reserve === 0): ?>
                        <h6 class=nothing>この日は、予約無し利用がありません。</h6>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>