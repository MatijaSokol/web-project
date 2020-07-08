<?php

    class MyPDO {
        protected static $instance;
        protected $pdo;

        private function __construct() {
            require_once('../common/constants.php');

            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => FALSE,
            );
            $dsn = 'mysql:host='.SERVERNAME.';dbname='.DBNAME.';charset='.CHARSET;
            $this->pdo = new PDO($dsn, USERNAME, PASSWORD, $opt);
        }

        // a classical static method to make it universally available
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        // a proxy to native PDO methods
        public function __call($method, $args) {
            return call_user_func_array(array($this->pdo, $method), $args);
        }

        // a helper function to run prepared statements smoothly
        public function run($sql, $args = []) {
            if (!$args) {
                return $this->query($sql);
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }
    }
?>