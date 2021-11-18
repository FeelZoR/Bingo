<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    http_response_code(302);
    header("Location: /index.php");
    exit();
}

session_destroy();
session_start();

$_SESSION['success'] = "Successfully disconnected!";
http_response_code(303);
header("Location: /index.php");
