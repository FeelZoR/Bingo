<?php
require_once '../config.php';
include_once ROOT_DIR . '/includes/model/Bingo.php';

if (empty($_GET['game'])) {
    $_SESSION['error'] = MISSING_GAME_NAME;
    http_response_code(302);
    header("Location: /play.php");
    exit();
}

$bingo = new \model\Bingo($db, $_GET['game']);
$cards = $bingo->getItems();
$title = "Game | Bingo";
ob_start();

?>
    <h1>Play new game</h1>

    <div class="bingo-grid">
        <?php foreach ($cards as $goal) { ?>
            <div
                    <?php if (strlen($goal['description']) > 0) { // Set data tooltip if description exists ?>
                        data-tooltip="<?php echo $goal['description']; ?>"
                    <?php } ?>
            >
                <?php echo $goal['title']; ?>
            </div>
        <?php } ?>
    </div>

<?php
$content = ob_get_clean();

include ROOT_DIR . '/templates/page.php';
