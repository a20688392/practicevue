<?php

###################
# 使用者登出API
# Jone 2022-07
###################

namespace App\Data;

require '../../../vendor/autoload.php';

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

session_start();

session_unset();
