<?php

function error(int $code) {
    http_response_code($code);
    echo '{}';
    exit();
}

if (!isset($_GET['name'])) {
    error(400);
}

require_once '../../config.php';

$gameStmt = $db->prepare('SELECT name FROM Games WHERE name LIKE :name ORDER BY name');
$gameStmt->execute([
    'name' => $_GET['name'] . '%'
]);

$games = [];
while (($game = $gameStmt->fetch()) !== false) {
    $games[] = $game['name'];
}

echo json_encode($games);
