<?php
require_once '../config.php';

$games = $db->query(
        'SELECT game AS name FROM Items I GROUP BY game HAVING COUNT(item_id) >= 25'
)->fetchAll();

$title = "Play Game | Bingo";
ob_start();

?>
    <h1>Play new game</h1>

    <form action="game.php" method="get">
        <select aria-label="Select Game" name="game">
            <?php if (sizeof($games) === 0) { ?>
                <option value="">No Game Available</option>
            <?php }

            foreach ($games as $game) { ?>
                <option value="<?php echo $game['name']; ?>"><?php echo $game['name']; ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="Play">
    </form>

<?php
$content = ob_get_clean();

include ROOT_DIR . '/templates/page.php';
