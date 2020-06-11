<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    class Validator {

        private static $instance = null;

        private function _construct() {}

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new Validator();
            }
            return self::$instance;
        }

        public function validateText($text) {
            $newText = filter_var($text, FILTER_SANITIZE_STRING);
            if (strcmp($text, $newText) == 0) {
                return true;
            } else {
                return false;
            }
        }

        public function validateEmail($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                return true;
            } else {
                return false;
            }
        }
    }

?>