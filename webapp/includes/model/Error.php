<?php

namespace model;

class Error {
    private $error;

    public function __construct(int $error_code) {
        $this->error = $error_code;
    }

    public function getMessage() {
        switch ($this->error) {
            case MISSING_USERNAME:
                return "Please provide a username.";
            case USERNAME_TAKEN:
                return "This username is already taken.";
            case MISSING_PWD:
                return "Please provide a password.";
            case MISSING_CONF:
                return "Please enter your password confirmation.";
            case PWD_NO_MATCH:
                return "The passwords don't match.";
            case USER_NOT_EXISTING:
                return "There is no user with this name.";
            case WRONG_PWD:
                return "Incorrect password.";
            case USERNAME_TOO_LONG:
                return "Your username is too long. It must contain less than 20 characters.";
            case MISSING_CAPTCHA:
                return "The captcha verification is missing.";
            case BAD_CAPTCHA:
                return "The captcha verification failed.";
            case MISSING_GAME_NAME:
                return "Please enter the name of the game you want to edit.";
            case GAME_NOT_FOUND:
                return "This game does not exist.";
            case MISSING_GOAL_TITLE:
                return "Please enter the title of the goal.";
            case GOAL_TOO_LONG:
                return "The title is too long. It must contain less than 70 characters.";
            case GOAL_DESC_TOO_LONG:
                return "The description is too long. It must contain less than 250 characters.";
            case GAME_ALREADY_EXISTS:
                return "This game already exists.";
        }
    }
}
