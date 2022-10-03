<?php

/**
 * PHP version 7
 *
 * @category Article
 * @package  App\Model
 * @author   Jone <author@domain.com>
 * @link     "http://localhost/
 */

###################
# 留言的處理函式
# Jone 2022-07
###################

namespace App\Model;

use App\Config\Database;
use PDO;
use Exception;
use PDOException;

class Comment
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
            die("錯誤!:" . $e->getMessage() . '<br>');
        }
        return $db;
    }

    /**
     * 搜尋留言人的名字
     *
     * @param   string      $comment_id     留言的ID
     * @return  string      $name['name']   姓名
     */
    public function searchCommentUser(string $comment_id)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("SELECT name FROM users JOIN comments ON      users.id = comments.user_id AND comments.id = ?");
        $statement->execute([$comment_id]);
        $name = $statement->fetch(PDO::FETCH_ASSOC);
        return $name['name'];
    }
    /**
     * 搜尋使用者姓名
     *
     * @param   integer     $user_id    使用者ID
     * @return  string      $name       使用者姓名
     */
    public function searchIDUser(int $user_id)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("SELECT name FROM users WHERE id=?");
        $statement->execute([$user_id]);
        $name = $statement->fetch(PDO::FETCH_ASSOC);
        isset($name['name']) ? $name = trim($name['name']) :  $name = '';
        return $name;
    }
    /**
     * 新增留言
     *
     * @param   string      $title      留言的標題
     * @param   string      $content    留言的內容
     * @param   integer     $user_id    留言的使用者 ID
     * @param   string      $token      留言身分驗證用的 Token
     *
     * @throws  Exception   $e          回應錯誤訊息
     * $token  不一致，丟出"請先登入"
     * $title、$content之一未填，丟出"標題或內容不能為空!!"
     * 使用者名不相符，丟出"不能以別人名義創建留言!!"
     *
     * @return  array       $return     將回傳的 API 回應資訊，回傳成功 *                                  或者失敗
     */
    public function addComment($title, $content, $user_id, $token)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("INSERT INTO `comments`(`title`,`content`,`user_id`) VALUES (?,?,?)");
        $return = [];

        $check_token = $_SESSION["MT"];

        try {
            if (!($check_token === $token)) {
                throw new Exception("請先登入");
            } elseif (empty($title) || empty($content)) {
                throw new Exception("標題或內容不能為空!!");
            } elseif (!($this->searchIDUser($user_id) === $_SESSION['userName'])) {
                throw new Exception("不能以別人名義創建留言!!");
            } elseif ($statement->execute([$title, $content, $user_id])) {
                $return = [
                    "event" => "創建訊息",
                    "status" => "success",
                    "content" => "創建成功",
                ];
            } else {
                throw new Exception("未知錯誤");
                /**
                 * log存檔?
                 */
            }
        } catch (PDOException $e) {
            $return = [
                "event" => "創建訊息",
                "status" => "error",
                "content" => "創建失敗",
            ];
        } catch (Exception $e) {
            $return = [
                "event" => "創建訊息",
                "status" => "error",
                "content" => "創建失敗，" . $e->getMessage(),
            ];
        }
        return $return;
    }

    /**
     * 判斷有沒有這留言
     * 用 1 、 0 來判斷有沒有這 ID
     *
     * @param   int $comment_id     留言的ID
     * @return  int $time           回應1 => true，0 => false
     */
    public function checkComment($comment_id)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("SELECT * FROM `comments` WHERE id=?");
        $statement->execute([$comment_id]);
        $time = $statement->rowCount();

        return $time;
    }
    /**
     * 編輯留言
     *
     * @param   integer     $comment_id         要更改的留言 ID
     * @param   string      $comment_title      要更改的留言標題
     * @param   string      $comment_content    要更改的留言內容
     * @param   string      $token              使用者的 Token
     *
     * @throws  Exception   $e                  回應錯誤訊息
     * $token  不一致，丟出"請先登入"
     * $comment_id 不存在，丟出"不能編輯不存在留言!!"
     * 使用者名不相符，丟出"不能以別人名義創建留言!!"
     * $title、$content之一未填，丟出"標題或內容不能為空!!"
     *
     * @return array        $return         將回傳的 API 回應資訊，回傳成功 *                                      或者失敗
     */
    public function editComment(int $comment_id, string $comment_title, string $comment_content, string $token)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("UPDATE comments SET title=?,content=? WHERE id=?");
        $return = [];

        $check_token = $_SESSION["MT"];

        //確認留言在不在
        try {
            if (!($check_token === $token)) {
                throw new Exception("請先登入");
            } elseif (!$this->checkComment($comment_id)) {
                throw new Exception("不能編輯不存在留言!!");
            } elseif (!($this->searchCommentUser($comment_id) === $_SESSION['userName'])) {
                throw new Exception("不能編輯別人的留言!!");
            } elseif (empty($comment_title) || empty($comment_content)) {
                throw new Exception("標題或內容不能為空!!");
            } elseif ($statement->execute([$comment_title, $comment_content, $comment_id])) {
                $return = [
                    "event" => "編輯訊息",
                    "status" => "success",
                    "content" => "編輯成功",
                ];
            } else {
                throw new Exception("未知錯誤");
                /**
                 * log存檔?
                 */
            }
        } catch (PDOException $e) {
            $return = [
                "event" => "編輯訊息",
                "status" => "error",
                "content" => "編輯失敗，",
            ];
        } catch (Exception $e) {
            $return = [
                "event" => "編輯訊息",
                "status" => "error",
                "content" => "編輯失敗，" . $e->getMessage(),
            ];
        }
        return $return;
    }
    /**
     * 刪除留言
     *
     * @param   integer       $comment_id     要更改的留言 ID
     * @param   string        $token          使用者的 Token
     *
     * @throws  Exception     $e              回應錯誤訊息
     * $token  不一致，丟出"請先登入"
     * 使用者名不相符，丟出"不能以別人名義創建留言!!"
     *
     * @return  array        $return         將回傳的 API 回應資訊，回傳成功 *                                      或者失敗
     */
    public function delComment($comment_id, $token)
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("DELETE FROM comments WHERE id= ?");
        $return = [];

        $check_token = $_SESSION["MT"];

        try {
            //確認使用者的夾帶token
            if (!($check_token === $token)) {
                throw new Exception("請先登入");
                //確認留言在不在
            } elseif (!$this->checkComment($comment_id)) {
                throw new Exception("不能刪除不存在留言!!");
            } elseif (!($this->searchCommentUser($comment_id) === $_SESSION['userName'])) {
                throw new Exception("不能刪除別人的留言!!");
            } elseif ($statement->execute([$comment_id])) {
                $return = [
                    "event" => "刪除訊息",
                    "status" => "success",
                    "content" => "刪除成功",
                ];
            } else {
                throw new Exception("未知錯誤");
            }
        } catch (PDOException $e) {
            $return = [
                "event" => "刪除訊息",
                "status" => "error",
                "content" => "刪除失敗",
            ];
        } catch (Exception $e) {
            $return = [
                "event" => "刪除訊息",
                "status" => "error",
                "content" => "刪除失敗，" . $e->getMessage(),
            ];
        }
        return $return;
    }

    /**
     * 回傳所有的留言
     *
     * @return  array    所有留言資訊
     */
    public function getAllComment()
    {
        $db = $this->dbConnect();
        $statement = $db->prepare("SELECT * FROM comments");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 搜尋留言
     *
     * @param   string      $search_content     搜尋內容
     * @param   string      $first_time         搜尋起始時間
     * @param   string      $last_time          搜尋末尾時間
     *
     * @throws  Exception   $e                  回應錯誤訊息
     *
     * $last_name > $first_time 迄 > 起時，
     * 丟出"起始搜尋時間比指定結束時間還要早"
     *
     * @return  array       $return             將回傳的 API 回應資訊，回傳成功 *                                          或者失敗
     */
    public function searchTimeComment(string $search_content, string $first_time, string $last_time)
    {
        $db = $this->dbConnect();
        $now_time = date('Y-m-d H:i:s');
        $old_Time = "2020-06-27 00:00:00";
        $return = [];
        $statement = [];
        try {
            //確認都不為空，為空只查詢關鍵字
            $param = "";
            if (empty($first_time) && empty($last_time)) {
                $sql = "SELECT * FROM comments  WHERE (title LIKE ? OR content LIKE ?)";
                $param = [
                    "%$search_content%", "%$search_content%"
                ];

                $statement = $db->prepare($sql);
                //確認都不為空，加入時間查詢
            } else {
                //當起時間未填，改為 2020-06-27 00:00:00，以前時間
                if (empty($first_time)) {
                    $first_time = $old_Time;
                }
                //當末時間未填，改為現在時間
                if (empty($last_time)) {
                    $last_time = $now_time;
                }
                //時間格式化，原本為 2022-07-14T00:00 ，再改為 2022-07-14 00:00:00
                $date = date_create($first_time);
                $first_time = date_format($date, "Y-m-d H:i:s");

                $date = date_create($last_time);
                $last_time = date_format($date, "Y-m-d H:i:s");

                //當時間為起大於末，會回傳起始搜尋時間比指定結束時間還要早，並傳回所有留言
                if (strtotime($first_time) > strtotime($last_time)) {
                    throw new Exception("起始搜尋時間比指定結束時間還要早");
                    //輸入資訊都沒問題
                } else {
                    $sql = "SELECT * FROM comments  WHERE 
		            (title LIKE ? OR content LIKE ?)
                    AND created_at BETWEEN ? AND ?";
                    $param = [
                        "%$search_content%", "%$search_content%", $first_time, $last_time
                    ];
                    $statement = $db->prepare($sql);
                }
            }
            //決定回傳訊息
            if ($statement->execute($param)) {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                $time = $statement->rowCount();
                $return = [
                    "event" => "搜尋訊息",
                    "status" => "success",
                    "content" => "搜尋結果擁有相符共 " . $time . " 筆",
                    "statement" => $data,
                ];
            } else {
                throw new Exception("未知錯誤");
            }
        } catch (PDOException $e) {
            $return = [
                "event" => "搜尋訊息",
                "status" => "error",
                "content" => "搜尋失敗",
            ];
        } catch (Exception $e) {
            $return = [
                "event" => "搜尋訊息",
                "status" => "error",
                "content" => "搜尋失敗，" . $e->getMessage(),
                "statement" => $this->getAllComment(),
            ];
        }
        return $return;
        //SELECT * FROM comments  WHERE (title LIKE "%test%" OR content LIKE "%test%") AND created_at BETWEEN "2020-06-27 00:00:00" AND "2022-07-08 16:29:02"
    }
}
