<?php

###################
# 創建新留言API
# Jone 2022-07
###################
namespace App\Data;

use App\Model\Comment;

require '../../../vendor/autoload.php';

//回應標頭
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

session_start();

//確認資料格式有傳來，沒傳到設為無、刪除前後空白、特殊符
isset($_POST['title']) ? $title = trim($_POST['title']) : $title = '';
isset($_POST['content']) ? $content = trim($_POST['content']) : $content = '';
isset($_POST['user_id']) ? $user_id = trim($_POST['user_id']) : $user_id = '';
isset($_POST['token']) ? $token = trim($_POST['token']) : $token = '';

$comment = new Comment();

$retrun = [];

//取得創建留言的回應，成功或失敗原因
if (isset($_SESSION["userName"])) {
    $return = $comment->addComment($title, $content, $user_id, $token);
} else {
    $return = [
        "event" => "創建訊息",
        "status" => "error",
        "content" => "創建失敗，請先登入",
    ];
}
echo json_encode($return);
