<?php

###################
# 創建使用者API
# Jone 2022-07
###################

namespace App\Data;

use App\Model\User;

require '../../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

//確認資料格式有傳來，沒傳到設為無、刪除前後空白、特殊符
isset($_POST['user_name']) ? $user_name = trim($_POST['user_name']) : $user_name = '';
isset($_POST['user_email']) ? $user_email = trim($_POST['user_email']) : $user_email = '';
isset($_POST['user_password']) ? $user_password = trim($_POST['user_password']) : $user_password = '';

$User = new User();

$return = $User->addUser($user_name, $user_email, $user_password);

echo json_encode($return);
