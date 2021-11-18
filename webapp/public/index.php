<?php
$title = "Bingo";
ob_start();

?>

<h1>Bingo</h1>

<div class="grid">
    <a href="/play.php" class="mode-selection">
        <article>Play a Game</article>
    </a>

    <a href="/create.php" class="mode-selection">
        <article>Create New Challenges</article>
    </a>
</div>

<?php
$content = ob_get_clean();

require_once '../config.php';
include ROOT_DIR . '/templates/page.php';
