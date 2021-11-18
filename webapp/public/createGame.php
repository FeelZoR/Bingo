<?php
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect'] = '/createGame.php';
    http_response_code(302);
    header("Location: /login.php");
    exit();
}

$title = "Create Game | Bingo";
ob_start();

?>
    <h1>Add New Game</h1>

    <form action="PRG/addGame.php" method="post">
        <?php $required = true; include ROOT_DIR . '/templates/gameSelector.php'; ?>

        <input type="submit" value="Add Game">
    </form>

<?php
$content = ob_get_clean();

include ROOT_DIR . '/templates/page.php';
