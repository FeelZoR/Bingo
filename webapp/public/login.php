<?php
require_once '../config.php';
if (isset($_SESSION['user_id'])) {
    http_response_code(302);
    header("Location: /index.php");
    exit();
}

$title = "Login | Bingo";
ob_start();

?>
    <h1>Log In</h1>

    <form action="PRG/login.php" method="post">
        <input type="text"
               id="name" name="name"
               placeholder="Username" aria-label="Username"
               maxlength="20" required
               autocomplete="username">

        <input type="password"
               id="pwd" name="pwd"
               placeholder="Password" aria-label="Password"
               required
               autocomplete="current-password">

        <input type="submit" value="Log In">
    </form>

    <small>Don't have an account? <a href="/register.php">Register here</a>.</small>

<?php
$content = ob_get_clean();

include ROOT_DIR . '/templates/page.php';
