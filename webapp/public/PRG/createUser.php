<?php

/* @var PDO $db */
require_once '../../config.php';
require_once ROOT_DIR . '/includes/consts.php';
require_once 'common.php';

$redirectUrl = $_SESSION['redirect'] ?? '/index.php';

// --- Check captcha
if (empty($_POST['captcha'])) {
    set_error(MISSING_CAPTCHA);
    redirect('/register.php', 303);
}

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array('secret' => getenv("SECRET_CAPTCHA"), 'response' => $_POST['captcha']);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === false) {
    http_response_code(500);
    exit();
}

if (json_decode($result, true)['success'] !== true) {
    set_error(BAD_CAPTCHA);
    redirect('/register.php', 303);
}

// --- Check all parameters one by one
if (empty($_POST['name'])) {
    set_error(MISSING_USERNAME);
    redirect('/register.php', 303);
}

$name = $_POST['name'];

if (strlen($name) > 20) {
    set_error(USERNAME_TOO_LONG);
    redirect('/register.php', 303);
}

$uniqueNameStmt = $db->prepare('SELECT COUNT(name) as existing FROM Users WHERE name=:name');
$uniqueNameStmt->execute(['name' => $name]);
if ($uniqueNameStmt->fetch()['existing'] == 1) {
    set_error(USERNAME_TAKEN);
    redirect('/register.php', 303);
}

if (empty($_POST['pwd'])) {
    set_error(MISSING_PWD);
    redirect('/register.php', 303);
}

if (empty($_POST['pwd_confirm'])) {
    set_error(MISSING_CONF);
    redirect('/register.php', 303);
}

$pwd = $_POST['pwd'];
$confirm = $_POST['pwd_confirm'];

if ($pwd != $confirm) {
    set_error(PWD_NO_MATCH);
    redirect('/register.php', 303);
}

$db->prepare('INSERT INTO Users(name, password) VALUES (:name, :pwd)')->execute([
   'name' => $name,
   'pwd' => password_hash($pwd, PASSWORD_ARGON2ID)
]);

set_success("Your account has been created, you may now log in.");
unset($_SESSION['redirect']);   // Consume redirection
redirect($redirectUrl, 303);
