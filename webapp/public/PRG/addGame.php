<?php

/* @var PDO $db */
require_once '../../config.php';
require_once ROOT_DIR . '/includes/consts.php';
require_once 'common.php';

if (!isset($_SESSION['user_id'])) {
    redirect('/login.php', 302);
}

// --- Check all parameters one by one
if (empty($_POST['game-name'])) {
    set_error(MISSING_GAME_NAME);
    redirect('/createGame.php', 303);
}

$gameName = $_POST['game-name'];

$gameExists = $db->prepare('SELECT COUNT(name) as existing FROM Games WHERE name=:name');
$gameExists->execute(['name' => $gameName]);
if ($gameExists->fetch()['existing'] == 1) {
    set_error(GAME_ALREADY_EXISTS);
    redirect('/createGame.php', 303);
}

$db->prepare('INSERT INTO Games(name) VALUES (:name)')->execute([
    'name' => $gameName
]);

set_success("New game created successfully.");
redirect('/create.php', 303);
