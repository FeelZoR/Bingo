<?php
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect'] = '/create.php';
    http_response_code(302);
    header("Location: /login.php");
    exit();
}

$title = "Create New Challenges | Bingo";
ob_start();

?>
    <h1>Add New Goal to Game</h1>

    <form action="PRG/addItem.php" method="post">
        <?php $required = true; include ROOT_DIR . '/templates/gameSelector.php'; ?>
        <input type="text"
               aria-label="Goal Title" placeholder="Goal Title"
               id="goal-title" name="goal-title"
               autocomplete="off"
               required maxlength="70">

        <input type="text"
               aria-label="Goal Description (optional)" placeholder="Goal Description (optional)"
               id="desc" name="desc"
               autocomplete="off"
               maxlength="250">

        <input type="submit" value="Create Goal">
    </form>

<?php
$content = ob_get_clean();

include ROOT_DIR . '/templates/page.php';
