<?php
require_once '../functions/db_connect.php';
require_once 'sql_logic.php';

class GetTime
{
        /**
     * 予約時間までの残り時間を取得する
     * @param str meeting_date & meeting_time from mysql
     * @return str '済' || difference time
     */
    public static function get_timelimit($meeting_date, $meeting_time, $id)
    {
        date_default_timezone_set('Asia/Tokyo');
        $reserve = new DateTime($meeting_date. ' '. $meeting_time);
        $current = new DateTime('now');
        // 時間が過ぎていたら値を返さない
        if($current >= $reserve){
            return '済';
        }
        $difference_time = $current->diff($reserve);
        $result = sprintf('%02d:%02d', $difference_time->h, $difference_time->i);
        return $result;
    }

    /**
     * 今日の日付を取得する（meeting_dateと同じ表し方）
     * @param null
     * @return str $today
     */
    public static function get_today_from_timestamp()
    {
        date_default_timezone_set('Asia/Tokyo');
        $today = date('Y-m-j');
        return $today;
    }
}
?>

