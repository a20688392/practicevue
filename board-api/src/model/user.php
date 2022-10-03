<?php

###################
# 使用者的處理函式
# Jone 2022-07
###################

namespace App\Model;

use App\Config\Database;
use PDO;
use Exception;
use PDOException;

class User
{
    /**
     * 進行與資料庫的初始連線
     * 回傳連線
     *
     * @return  db          $db     資料庫的連線
     * @throws  Exception   $e      回應錯誤訊息
     */
    public function dbConnect()
    {
        $db_type = Database::DATABASE_INFO['db_type'];
        $db_host = Database::DATABASE_INFO['db_host'];
        $db_name = Database::DATABASE_INFO['db_name'];
        $db_user = Database::DATABASE_INFO['db_user'];
        $db_password = '';
        $connect = $db_type . ":host=" . $db_host . ";dbname=" . $db_name;
        try {
            $db = new PDO($connect, $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->query("SET NAMES UTF8");
        } catch (PDOException $e) {
            die("Error!:" . $e->getMessage() . '<br>');
        }
        return $db;
    }
    /**
     * 檢查信箱、使用者是否已註冊過
     *
     * @param   string  $user_name   使用者名
     * @param   string  $user_email  使用者信箱
     * @return  array
     * name_RESULT      為0 時，代表沒有被註冊過，1為有
     * email_RESULT     為0 時，代表沒有被註冊過，1為有
     */
    public function checkEmailName(string $user_name, string $user_email)
    {
        $db = $this->dbConnect();
        $sql = "SELECT IF( EXISTS(
                            SELECT name
                            FROM users
                            WHERE name = ?), 1, 0) as name_RESULT,
                        IF( EXISTS(
                            SELECT email
                            FROM users
                            WHERE email = ?), 1, 0) as email_RESULT;";
        $statement = $db->prepare($sql);
        $statement->execute([$user_name, $user_email]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * 註冊使用者
     *
     * @param   string  $user_name      使用者名
     * @param   string  $user_email     使用者信箱
     * @param   string  $user_password  使用者密碼
     *
     * @throws  Exception   $e          回應錯誤訊息
     *
     * $user_name、$user_email、$user_password 之一未填
     * 回傳 "有欄位未填"
     *
     * $user_email FILTER_SANITIZE_EMAIL、FILTER_VALIDATE_EMAIL
     * 為true，代表信箱格是不合規定，
     * 回傳 "信箱格式錯誤" . "<br>" . "信箱範例：test@example.com"
     *
     * name_RESULT      為0 時，代表沒有被註冊過，1為有
     * 回傳 "使用者名已被註冊"
     *
     * email_RESULT     為0 時，代表沒有被註冊過，1為有
     * 回傳 "信箱已被註冊"
     * 同時都有回傳 "使用者名和信箱已被註冊"
     *
     * @return  array       $return     將回傳的 API 回應資訊，回傳成功 *                                  或者失敗
     */
    public function addUser(string $user_name, string $user_email, string $user_password)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (?,?,?)";
        $statement = $db->prepare($sql);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $check = $this->checkEmailName($user_name, $user_email);
        $return = [];

        try {
            if (empty($user_name) || empty($user_password) || empty($user_email)) {
                throw new Exception("有欄位未填");
            //信箱
            //把值作為電子郵件地址來驗證
            //過濾允許所有的字母、數字以及$-_.+!*'{}|^~[]`#%/?@&=
            } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL) || !filter_var($user_email, FILTER_SANITIZE_EMAIL)) {
                throw new Exception("信箱格式錯誤" . "<br>" . "信箱範例：test@example.com");
            } elseif ($check['name_RESULT'] || $check['email_RESULT']) {
                if (($check['name_RESULT'] && $check['email_RESULT'])) {
                    throw new Exception("使用者名和信箱已被註冊");
                } elseif ($check['name_RESULT']) {
                    throw new Exception("使用者名已被註冊");
                } else {
                    throw new Exception("信箱已被註冊");
                }
            } elseif ($statement->execute([$user_name, $user_email, $user_password])) {
                $return = [
                    "event" => "註冊訊息",
                    "status" => "success",
                    "content" => "註冊成功",
                ];
            } else {
                throw new Exception("未知錯誤" . $statement->errorInfo()[2]);
            }
        } catch (PDOException $e) {
            $return = [
                "event" => "註冊訊息",
                "status" => "error",
                "content" => "註冊失敗" . $e->getMessage(),
            ];
        } catch (Exception $e) {
            $return = [
                "event" => "註冊訊息",
                "status" => "error",
                "content" => "註冊失敗，" . $e->getMessage(),
            ];
        }
        return $return;
    }
    /**
     * 使用者登入
     *
     * @param   string  $user_name      使用者名
     * @param   string  $user_password  使用者密碼
     *
     * @throws  Exception   $e          回應錯誤訊息
     *
     * $user_name、$user_email、$user_password 之一未填
     * 回傳 "有欄位未填"
     *
     * 密碼或帳號錯誤
     * 回傳 "帳號名或密碼錯誤"
     *
     * @return  array       $return     將回傳的 API 回應資訊，回傳成功 *                                  或者失敗
     */
    public function userLogin(string $user_name, string $user_password)
    {
            $db = $this->dbConnect();
            $statement = $db->prepare("SELECT * FROM users WHERE `name`=?");
            $statement->execute([$user_name]);
            $return = [];
        try {
            if (empty($user_name) || empty($user_password)) {
                throw new Exception("有欄位未填!!");
            //確認有沒有帳號
            } elseif (!$statement->rowCount()) {
                    throw new Exception("帳號名或密碼錯誤");
            } else {
                $data = $statement->fetch(PDO::FETCH_ASSOC);
                $password_hash = $data['password'];
                $user_id = $data['id'];
                $email = $data['email'];
                $pass = password_verify($user_password, $password_hash);

                if ($pass) {
                    $_SESSION["userName"] = $user_name;

                    $Token = $this->token($user_name);
                    $_SESSION["MT"] = $Token;

                    $return = [
                    "user_name" => $user_name,
                    "user_id" => $user_id,
                    "email" => $email,
                    "checkname" => true,
                    "event" => "登入訊息",
                    "status" => "success",
                    "content" => "登入成功，歡迎 $user_name 登入",
                    "board" => $Token,
                    ];
                    //確認有沒有密碼錯誤
                } else {
                    throw new Exception("帳號名或密碼錯誤");
                }
            }
        } catch (PDOException $e) {
            $return = [
            "checkname" => false,
            "event" => "登入訊息",
            "status" => "error",
            "content" => "登入失敗",
            ];
        } catch (Exception $e) {
            $return = [
            "checkname" => false,
            "event" => "登入訊息",
            "status" => "error",
            "content" => "登入失敗，" . $e->getMessage(),
            ];
        }
        return $return;
    }
    /**
     * 尋找使用者
     *
     * @param   string  $user_name      使用者名
     *
     * @throws  Exception   $e          回應錯誤訊息
     *
     * 有例外錯誤
     * 回傳 "未知錯誤"
     *
     * @return  array       $return     回傳使用者資訊
     */
    public function findUser($user_name)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("SELECT * FROM users WHERE `name`=?");
        $return = [];
        //沒有代表有人來亂
        try {
            $statement->execute([$user_name]);
            if ($statement->rowCount()) {
                $data = $statement->fetch(PDO::FETCH_ASSOC);
                $return = [
                "user_name" => $data['name'],
                "user_id" =>  $data['id'],
                "email" => $data['email'],
                "checkname" => true,
                ];
            } else {
                throw new Exception("未知錯誤");
            }
        } catch (PDOException $e) {
            $return = [
            "無此使用者",
            ];
        } catch (Exception $e) {
            $return = [
            $e->getMessage(),
            ];
        }
        return $return;
    }
    /**
     * 產生唯一Token
     *
     * 使用 MD5 的方式創造Token
     *
     * @param   string      $user   使用者名
     * @return  string      $token  使用者的Token驗證碼
     */
    public function token(string $user)
    {
        $time = time();
        $sign = "jonetest";
        $sign = md5($sign);
        $json_token = [
        'user' => $user,
        'time' => $time,
        'sign' => $sign,
        ];
        $token = json_encode($json_token);
        $token = md5($token);
        return $token;
    }
}
