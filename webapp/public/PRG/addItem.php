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
    redirect('/create.php', 303);
}

$gameName = $_POST['game-name'];

$gameExists = $db->prepare('SELECT COUNT(name) as existing FROM Games WHERE name=:name');
$gameExists->execute(['name' => $gameName]);
if ($gameExists->fetch()['existing'] == 0) {
    set_error(GAME_NOT_FOUND);
    redirect('/create.php', 303);
}

if (empty($_POST['goal-title'])) {
    set_error(MISSING_GOAL_TITLE);
    redirect('/create.php', 303);
}

$goalTitle = $_POST['goal-title'];
if (strlen($goalTitle) > 70) {
    set_error(GOAL_TOO_LONG);
    redirect('/create.php', 303);
}

if (!empty($_POST['desc'])) {
    $goalDesc = $_POST['desc'];
    if (strlen($goalDesc) > 250) {
        set_error(GOAL_DESC_TOO_LONG);
        redirect('/create.php', 303);
    }

    $db->prepare('INSERT INTO Items(title, description, game, author) VALUES (:title, :desc, :game, :author)')->execute([
        'title' => $goalTitle,
        'desc' => $goalDesc,
        'game' => $gameName,
        'author' => $_SESSION['user_id']
    ]);
} else {
    $db->prepare('INSERT INTO Items(title, game, author) VALUES (:title, :game, :author)')->execute([
        'title' => $goalTitle,
        'game' => $gameName,
        'author' => $_SESSION['user_id']
    ]);
}

set_success("New goal added successfully.");
redirect('/create.php', 303);
