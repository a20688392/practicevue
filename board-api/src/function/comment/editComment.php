<?php

###################
# 編輯留言API
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
isset($_POST['comment_id']) ? $comment_id = trim($_POST['comment_id']) : $comment_id = '';
isset($_POST['comment_title']) ? $comment_title = trim($_POST['comment_title']) : $comment_title = '';
isset($_POST['comment_content']) ? $comment_content = trim($_POST['comment_content']) : $comment_content = '';
isset($_POST['token']) ? $token = trim($_POST['token']) : $token = '';

$comment = new Comment();

$return = [];

//取得編輯留言的回應，成功或失敗原因
if (isset($_SESSION["userName"])) {
    $return = $comment->editComment($comment_id, $comment_title, $comment_content, $token);
} else {
    $return = [
        "event" => "編輯訊息",
        "status" => "error",
        "content" => "編輯失敗，請先登入",
    ];
}

echo json_encode($return);
