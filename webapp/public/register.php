<?php
require_once '../config.php';
if (isset($_SESSION['user_id'])) {
    http_response_code(302);
    header("Location: /index.php");
    exit();
}

$title = "Register | Bingo";
ob_start();

?>
    <h1>Create New Account</h1>

    <form action="PRG/createUser.php" method="post">
        <input type="text"
               id="name" name="name"
               placeholder="Username" aria-label="Username"
               required maxlength="20"
               autocomplete="username">

        <input type="password"
               id="pwd" name="pwd"
               placeholder="Password" aria-label="Password"
               required
               autocomplete="new-password">

        <input type="password"
               id="pwd_confirm" name="pwd_confirm"
               placeholder="Confirm Password" aria-label="Confirm Password"
               required
               autocomplete="new-password">

        <input type="hidden" id="captcha" name="captcha">

        <small>Be careful! If you lose your password, you will lose access to your account. We won't be able to
        help you. We suggest using a solution such as <a href="https://bitwarden.com/">Bitwarden</a> to store
        your passwords.</small>

        <button type="submit">Sign Up</button>
    </form>

    <small>Already have an account? <a href="/login.php">Log in here</a>.</small>

    <div id="captcha-badge"></div>

    <!-- CAPTCHA SECTION -->
    <script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=onRecaptchaLoadCallback"></script>
    <script>
        function onRecaptchaLoadCallback() {
            var clientId = grecaptcha.render('captcha-badge', {
                'sitekey': '<?php echo getenv('CAPTCHA_SITEKEY') ?>',
                'badge': 'bottomleft',
                'size': 'invisible'
            });

            grecaptcha.ready(function() {
                grecaptcha.execute(clientId, {
                    action: 'submit'
                })
                    .then(function(token) {
                        document.getElementById('captcha').value = token;
                    });
            });
        }
    </script>
<?php
$content = ob_get_clean();

require_once '../config.php';
include ROOT_DIR . '/templates/page.php';
