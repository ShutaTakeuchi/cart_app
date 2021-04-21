<?php
require_once '../functions/db_connect.php';
require_once 'app_logic.php';

// 件数取得クラス
class TotalItemLogic
{
    /**
     * 各件数を配列に入れる
     * @return array $item
     */
    public static function get_item_today_total()
    {
        $item = [];

        // reserveの一般とVIPの件数をカウント 
        $item['reserve_general'] = self::count_reserve_status_item('reserve', '一般');
        $item['reserve_vip'] = self::count_reserve_status_item('reserve', 'VIP');
        // reserveの出発、到着の件数をカウント
        $item['reserve_dep'] = self::count_reserve_flight_type_item('reserve', '出発');
        $item['reserve_arr'] = self::count_reserve_flight_type_item('reserve', '到着');
        // reserveのANA, HD, 6J, MQの件数をカウント
        $item['reserve_ana'] = self::count_reserve_company_item('reserve', 'ANA');
        $item['reserve_hd'] = self::count_reserve_company_item('reserve', 'HD');
        $item['reserve_6j'] = self::count_reserve_company_item('reserve', '6J');
        $item['reserve_mq'] = self::count_reserve_company_item('reserve', 'MQ');
        // reserveの全件をカウント
        $item['reserve_all'] = $item['reserve_general'] + $item['reserve_vip'];

        // standby_recordのANA, HD, 6J, MQの件数をカウント
        $item['standby_record_ana'] = self::count_standby_record_company_item('standby_record', 'ANA');
        $item['standby_record_hd'] = self::count_standby_record_company_item('standby_record', 'HD');
        $item['standby_record_6j'] = self::count_standby_record_company_item('standby_record', '6J');
        $item['standby_record_mq'] = self::count_standby_record_company_item('standby_record', 'MQ');
        // standby_recordの全件をカウント
        $item['standby_record_all'] = $item['standby_record_ana'] + $item['standby_record_hd'] + $item['standby_record_6j'] + $item['standby_record_mq'];

        // 予約有り、予約無しの合計の件数
        $item['all'] = $item['reserve_all'] + $item['standby_record_all'];

        return $item;
    }

    /**
     * reserveの案内済みの一般とVIPの件数をカウント
     */
    public static function count_reserve_status_item($table, $status)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE reserve_status='1' AND passenger_status='".$status ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * reserveの案内済みの出発と到着の件数をカウント
     */
    public static function count_reserve_flight_type_item($table, $flight_type)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE reserve_status='1' AND flight_type='".$flight_type ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * reserveの案内済みのキャリア別の件数をカウント
     */
    public static function count_reserve_company_item($table, $flight_company)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE reserve_status='1' AND flight_company='".$flight_company ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * standby_recordのキャリア別の件数を取得
     */
    public static function count_standby_record_company_item($table, $flight_company)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE flight_company='".$flight_company ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }
}

// 人数取得クラス
class TotalNumberLogic
{
    /**
     * 各人数を配列に入れる
     * @return array $number
     */
    public static function get_number_today_total()
    {
        $number = [];

        // reserveの各旅客ステータスの人数をカウント
        $number['reserve_general'] = self::count_reserve_status_number('reserve', '一般');
        $number['reserve_vip'] = self::count_reserve_status_number('reserve', 'VIP');
        // reserveの出発、到着の人数をカウント
        $number['reserve_dep'] = self::count_reserve_flight_type_number('reserve', '出発');
        $number['reserve_arr'] = self::count_reserve_flight_type_number('reserve', '到着');
        // reserveの各キャリアの人数をカウント
        $number['reserve_ana'] = self::count_reserve_company_number('reserve', 'ANA');
        $number['reserve_hd'] = self::count_reserve_company_number('reserve', 'HD');
        $number['reserve_6j'] = self::count_reserve_company_number('reserve', '6J');
        $number['reserve_mq'] = self::count_reserve_company_number('reserve', 'MQ');
        // reserveの全人数をカウント
        $number['reserve_all'] = $number['reserve_general'] + $number['reserve_vip'];

        // standby_recordの各キャリアの人数をカウント
        $number['standby_record_ana'] = self::count_standby_record_company_number('standby_record', 'ANA');
        $number['standby_record_hd'] = self::count_standby_record_company_number('standby_record', 'HD');
        $number['standby_record_6j'] = self::count_standby_record_company_number('standby_record', '6J');
        $number['standby_record_mq'] = self::count_standby_record_company_number('standby_record', 'MQ');
        // standby_recordの全人数をカウント
        $number['standby_record_all'] = $number['standby_record_ana'] + $number['standby_record_hd'] + $number['standby_record_6j'] + $number['standby_record_mq'];

        // 予約有り、予約無しの合計の人数
        $number['all'] = $number['reserve_all'] + $number['standby_record_all'];

        // nullを０にする処理
        foreach($number as $k=>$v){
            if(!$v){
                $v = 0;
            }
            $number[$k] = $v;
        }

        return $number;
    }

    /**
     * reserveの各旅客ステータスの人数を取得
     */
    public static function count_reserve_status_number($table, $status)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT SUM(number_of_people) FROM $table WHERE reserve_status='1' AND passenger_status='".$status ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * reserveの出発、到着の人数を取得
     */
    public static function count_reserve_flight_type_number($table, $flight_type)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT SUM(number_of_people) FROM $table WHERE reserve_status='1' AND flight_type='".$flight_type ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * reserveの各キャリアの人数を取得
     */
    public static function count_reserve_company_number($table, $flight_company)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT SUM(number_of_people) FROM $table WHERE reserve_status='1' AND flight_company='".$flight_company ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * standby_recordの各キャリアの人数を取得
     */
    public static function count_standby_record_company_number($table, $flight_company)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT SUM(number_of_people) FROM $table WHERE flight_company='".$flight_company ."' AND share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }
}