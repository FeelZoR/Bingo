<?php include_once ROOT_DIR . '/includes/model/Error.php'; ?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="static/css/main.css">
</head>
<body>
    <nav class="container-fluid">
        <ul>
            <li class="title"><a href="/index.php"><strong>Bingo</strong></a></li>
        </ul>
        <ul>
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <li><a href="/register.php" role="button" class="outline secondary">Register</a></li>
                <li><a href="/login.php" role="button">Login</a></li>
            <?php } else { ?>
                <li>Welcome, <?php echo $_SESSION['name'] ?></li>
                <li><a href="/logout.php" role="button">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>


    <main class="container">
        <?php
        if ($error !== NO_ERROR) {
            $bannerType = 'error-banner';
            $message = (new \model\Error($error))->getMessage();
            include ROOT_DIR . '/templates/banner.php';
        }

        if ($success !== "") {
            $bannerType = 'success-banner';
            $message = $success;
            include ROOT_DIR . '/templates/banner.php';
        }

        echo $content; ?>
    </main>

    <button id="dark_mode">&nbsp;</button>

    <script src="static/js/main.js"></script>
</body>
</html>
