<?php

/* @var PDO $db */
require_once '../../config.php';
require_once ROOT_DIR . '/includes/consts.php';
require_once 'common.php';

$redirectUrl = $_SESSION['redirect'] ?? '/index.php';

// --- Check all parameters one by one
if (empty($_POST['name'])) {
    set_error(MISSING_USERNAME);
    redirect('/login.php', 303);
}

$userStmt = $db->prepare('SELECT * FROM Users WHERE name=:name');
$userStmt->execute(['name' => $_POST['name']]);

$user = $userStmt->fetch();
if ($user === false) {
    set_error(USER_NOT_EXISTING);
    redirect('/login.php', 303);
}

if (empty($_POST['pwd'])) {
    set_error(MISSING_PWD);
    redirect('/login.php', 303);
}

if (!password_verify($_POST['pwd'], $user['password'])) {
    set_error(WRONG_PWD);
    redirect('/login.php', 303);
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['name'] = $user['name'];
unset($_SESSION['redirect']);   // Consume redirection
set_success("Successfully logged in!");
redirect($redirectUrl, 303);
