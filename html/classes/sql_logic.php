<?php
require_once '../functions/db_connect.php';
require_once 'app_logic.php';

class SqlLogic
{
    /**
     * 各テーブルの一覧を取得する（当日のみの表示）
     * @param str table_name of database
     * @return object PDOStatement
     */
    public static function get_table($table)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = 'SELECT * FROM '. $table. ' WHERE share_date="'. $today. '" ORDER BY id DESC';
        $records = $pdo->query($sql);
        return $records;
    }

        /**
     * 各テーブルの一覧を取得する（特定の日のみ表示）
     * @param str table_name of database
     * @return object PDOStatement
     */
    public static function get_selected_table($table, $date)
    {
        $pdo = db_connect();
        $sql = 'SELECT * FROM '. $table. ' WHERE share_date="'. $date. '" ORDER BY id DESC';
        $records = $pdo->query($sql);
        return $records;
    }

    /**
     * 新規電動カートの予約を登録する
     * @param array $_SESSION['reserve_info']
     * @return bool
     */
    public static function reserve_create_table($reserve_info)
    {
        $pdo = db_connect();
        $sql = 'INSERT INTO reserve SET passenger_status=?, flight_type=?, flight_company=?, flight_number=?, passenger_name=?, number_of_people=?, meeting_time=?, meeting_place=?, destination=?, other_info=?, share_staff=?, share_date=?, reserve_status=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $reserve_info['status'],
            $reserve_info['flight_type'],
            $reserve_info['flight_company'],
            $reserve_info['flight_number'],
            $reserve_info['passenger_name'],
            $reserve_info['number_of_people'],
            $reserve_info['meeting_time'],
            $reserve_info['meeting_place'],
            $reserve_info['destination'],
            $reserve_info['other_info'],
            $reserve_info['share_staff'],
            $reserve_info['share_date'],
            $reserve_info['reserve_status'],
        ));
        return $stmt;
    }

    /**
     * 新規フライト情報を登録する
     * @param array $_POST
     * @return bool
     */
    public static function flight_info_create_table($flight_info)
    {
        $pdo = db_connect();
        $sql = 'INSERT INTO flight_info SET flight_name=?, content=?, share_staff=?, share_date=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $flight_info['flight_name'],
            $flight_info['content'],
            $flight_info['share_staff'],
            $flight_info['share_date']
        ));
        return $stmt;
    }

    /**
     * 新規その他情報を登録する
     * @param array $_POST
     * @return bool
     */
    public static function other_info_create_table($other_info)
    {
        $pdo = db_connect();
        $sql = 'INSERT INTO other_info SET content=?, share_staff=?, share_date=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $other_info['content'],
            $other_info['share_staff'],
            $other_info['share_date']
        ));
        return $stmt;
    }

    /**
     * 新規予約なし利用を登録する
     * @param array $_POST
     * @return bool
     */
    public static function standby_record_create_table($standby_record_info)
    {
        $pdo = db_connect();
        $sql = 'INSERT INTO standby_record SET flight_company=?, flight_number=?, passenger_name=?, number_of_people=?, meeting_time=?, meeting_place=?, destination=?, person_in_charge=?, share_date=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $standby_record_info['flight_company'],
            $standby_record_info['flight_number'],
            $standby_record_info['passenger_name'],
            $standby_record_info['number_of_people'],
            $standby_record_info['meeting_time'],
            $standby_record_info['meeting_place'],
            $standby_record_info['destination'],
            $standby_record_info['person_in_charge'],
            $standby_record_info['share_date']
        ));
        return $stmt;
    }

    /**
     * 各一覧のテーブルから特定の一つのレコードを取得する（予約の編集のため）
     * @param str table_name && int_id_from_sql
     * @return array one_data_from_sql
     */
    public static function get_one_data($table, $id)
    {
        $pdo = db_connect();
        $sql = 'SELECT * FROM '. $table. ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $one_data = $stmt->fetch();
        return $one_data;
    }

    /**
     * 電動カート予約内容の変更をする処理
     * @param array one_record_from_sql
     * @return bool
     */
    public static function update_reserve($updated_data)
    {
        $pdo = db_connect();
        $sql = 'UPDATE reserve SET passenger_status=?, flight_type=?, flight_company=?, flight_number=?, passenger_name=?, number_of_people=?, meeting_time=?, meeting_place=?, destination=?, other_info=?, share_staff=?, share_date=? WHERE id=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $updated_data['status'],
            $updated_data['flight_type'],
            $updated_data['flight_company'],
            $updated_data['flight_number'],
            $updated_data['passenger_name'],
            $updated_data['number_of_people'],
            $updated_data['meeting_time'],
            $updated_data['meeting_place'],
            $updated_data['destination'],
            $updated_data['other_info'],
            $updated_data['share_staff'],
            $updated_data['share_date'],
            $updated_data['id']
        ));
        return $stmt;
    }

    /**
     * レコードの削除をする処理
     * @param str table_from_database
     * @return int id
     */
    public static function delete_content($table, $delete_id)
    {
        $pdo = db_connect();
        $sql = 'DELETE FROM '. $table. ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(array($delete_id));
        return $result;
    }

    /**
     * 各テーブルの件数をカウントする処理（当日のみの処理）
     * @param str name_of_table
     * @return int count_of_record
     */
    public static function count_data($table)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE share_date='". $today. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * 各テーブルの件数をカウントする処理（当日のみの処理）
     * @param str name_of_table
     * @return int count_of_record
     */
    public static function count_history_data($table, $date)
    {
        $pdo = db_connect();
        $sql = "SELECT COUNT(*) FROM $table WHERE share_date='". $date. "'";
        $count = $pdo->query($sql);
        return $count->fetchColumn();
    }

    /**
     * 翌日になったらレコードが削除される処理
     * @param str table-name from database
     * @return int id
     */
    public static function delete_info($table)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = 'DELETE FROM '. $table. ' WHERE NOT share_date = "'. $today. '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * ご案内済みに0から1に変更する処理
     * @param int $id
     */
    public static function change_reserve_status($id)
    {
        $pdo = db_connect();
        $sql = 'UPDATE reserve SET reserve_status="1" WHERE id=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
    }

    /**
     * 次の一番近いご案内を取得する
     * @param str table_name of database
     * @return object PDOStatement
     */
    public static function get_early_reserve($table)
    {
        $today = GetTime::get_today_from_timestamp();
        $pdo = db_connect();
        $sql = 'SELECT * FROM '. $table. ' WHERE reserve_status="0" AND share_date="'. $today. '" ORDER BY id DESC';
        $records = $pdo->query($sql);
        return $records;
    }

    /**
     * 当日分reserveテーブルのデータを全件取得して、ご案内終了のデータにはreserve_statusを1にする
     * 
     * 
     */
    public static function if_reserve_finished()
    {
        $today_data = self::get_table('reserve');
        while($data = $today_data->fetch()){
            date_default_timezone_set('Asia/Tokyo'); 
            $reserve = new DateTime($data['meeting_date']. ' '. $data['meeting_time']);
            $current = new DateTime('now');
            // 時間が過ぎていたら処理をする
            if($current >= $reserve){
                self::change_reserve_status($data['id']);;
            }
        }
    }

}
?>