<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    class User {
        public $firstname;
        public $lastname;
        public $username;
        public $password;
        public $email;

        public function __construct($firstname, $lastname, $username, $password, $email) {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
        }
    }

?>