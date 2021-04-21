<?php
session_start();
require_once '../functions/db_connect.php';

class Login
{
    /**
     * postメソッドでの値があるかどうかを判定する
     * @param str $_POST['username'], $_POST['password']
     * @return bool false , str $_POST['username'], $_POST['password']
     */
    public static function check_data_exist($username, $password)
    {
        if($username && $password){
            $final_result = Login::check_username_and_password($username, $password);
            return $final_result;
        }else{
            $_SESSION['null_err'] = 'ユーザ名、パスワードを入力してください。';
            header('Location: ../public/login.php');
            exit;
        }
    }
    
    /**
     * ユーザーとパスワードの判定を行う
     * @param str $_POST['username'] $_POST['password']
     * @return bool $result 
     */
    public static function check_username_and_password($username, $password)
    {
        $pdo = db_connect();
        $result = false;

        // ユーザ名を照会する
        $result_user = self::check_username($pdo, $username);
        if($result_user){
            // ユーザ名が合っていた時の処理
            $result_password = self::check_password($result_user, $password);
            if($result_password){
                // ユーザ名とパスワードが照会できたときの処理
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;

            }else{
                // パスワードが間違っている時の処理
                $_SESSION['login_err'] = 'ユーザ名またはパスワードが違います。';
                header('Location: ../public/login.php');
                exit;
            }
            
        }else{
            // ユーザ名が間違っている時の処理
            $_SESSION['login_err'] = 'ユーザ名またはパスワードが違います。';
            header('Location: ../public/login.php');
            exit;
        } 
    }

    /**
     * ユーザ名の判定
     * @param object $pdo, str $_POST['username']
     * @return bool | array, false | record from sql
     */
    public static function check_username($pdo, $username)
    {
        $sql = 'SELECT * FROM login WHERE username = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($username));
        $record = $stmt->fetch();
        return $record;
    }

    /**
     * パスワードの判定
     * @param
     * @return bool false || true
     */
    public static function check_password($result_username, $password)
    {
        $result = false;
        // パスワードを判定する処理
        if($password === $result_username['password']){
            $result = true;
            return $result;
        }else{
            return $result;
        }
        
    }
}