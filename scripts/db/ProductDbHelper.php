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

        public function findAllMyAds($owner) {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE owner = ?');
            $stmt->execute([$owner]);
            return $stmt->fetchAll();
        }

        public function findAllSearchedAds($pattern) {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE name LIKE ? OR  description LIKE ?');
            $stmt->execute(['%' . $pattern . '%', '%' . $pattern . '%']);
            return $stmt->fetchAll();
        }

        public function findAllMySearchedAds($pattern, $username) {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE (name LIKE ? OR  description LIKE ?) AND owner = ?');
            $stmt->execute(['%' . $pattern . '%', '%' . $pattern . '%', $username]);
            return $stmt->fetchAll();
        }

        public function findAdById($id) {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function insertAd(Product $product) {
            $stmt = $this->db->prepare("INSERT INTO products (name, description, price, owner, image) VALUES (?, ?, ?, ?, ?)");
            $valid = $stmt->execute([$product->name, $product->description, $product->price, $product->owner, $product->image]);
            return $valid;
        }

        public function deleteAdById($id) {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
            $valid = $stmt->execute([$id]);
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