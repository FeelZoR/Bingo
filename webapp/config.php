<?php

const ROOT_DIR = __DIR__;

$host = 'db';
$db_name = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');

$dsn = "mysql:host=$host;dbname=$db_name;charset=UTF8";

try {
    $db = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle session related infos
include_once 'includes/consts.php';
session_start();

$error = $_SESSION['error'] ?? NO_ERROR;
unset($_SESSION['error']);

$success = $_SESSION['success'] ?? "";
unset($_SESSION['success']);
