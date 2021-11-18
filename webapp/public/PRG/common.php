<?php

/**
 * Redirect and set a status code.
 * Immediately stops the execution and send the response.
 * @param String $url   - The url to which the user will be redirected. (set in response headers with Location)
 * @param int $code     - The HTML response code.
 */
function redirect(String $url, int $code) {
    http_response_code($code);
    header("Location: $url");
    exit();
}

/**
 * Add an error in the user session for further display.
 * @param int $code - The error code, found in consts.php
 */
function set_error(int $code) {
    $_SESSION['error'] = $code;
}

/**
 * Add a successful message in the user session for further display.
 * @param String $message - The message to display
 */
function set_success(String $message) {
    $_SESSION['success'] = $message;
}
