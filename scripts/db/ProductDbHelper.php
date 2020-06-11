<?php

    class ProductDbHelper {
        
        protected $db;
        public $data;
        private static $instance = null;

        private function __construct(MyPDO $db) {
            $this->db = $db;
        }

        public function findAll() {
            return $this->db->query("SELECT * FROM products")->fetchAll();
        }

        public function findAllMyProducts($owner) {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE owner = ?');
            $stmt->execute([$owner]);
            return $stmt->fetchAll();
        }

        public function insertProduct(Product $product) {
            $stmt = $this->db->prepare("INSERT INTO products (name, description, price, owner, image) VALUES (?, ?, ?, ?, ?)");
            $valid = $stmt->execute([$product->name, $product->description, $product->price, $product->owner, $product->image]);
            return $valid;
        }

        public static function getInstance(MyPDO $db) {
            if (self::$instance == null) {
                self::$instance = new ProductDbHelper($db);
            }
            return self::$instance;
        }
    }
?>