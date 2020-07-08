<?php

    class UserDbHelper {
        
        protected $db;
        public $data;
        private static $instance = null;

        private function __construct(MyPDO $db) {
            $this->db = $db;
        }

        public function findAll() {
            return $this->db->query("SELECT * FROM users")->fetchAll();
        }

        public function findUserByUsername($username) {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $exist = $stmt->fetch();
            return $exist;
        }

        public function findUserByUsernameAndPassword($username, $password) {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
            $stmt->execute([$username, $password]);
            $exist = $stmt->fetch();
            return $exist;
        }

        public function insertUser(User $user) {
            $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, username, password, email) VALUES (?, ?, ?, ?, ?)");
            $valid = $stmt->execute([$user->firstname, $user->lastname, $user->username, $user->password, $user->email]);
            return $valid;
        }

        public function closeConnection() {
            $db = null;
            $data = null;
        }

        public static function getInstance(MyPDO $db) {
            if (self::$instance == null) {
                self::$instance = new UserDbHelper($db);
            }
            return self::$instance;
        }
    }
?>