<?php

    class Product {
        public $name;
        public $description;
        public $price;
        public $owner;
        public $image;

        public function __construct($name, $description, $price, $owner, $image) {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->owner = $owner;
            $this->image = $image;
        }
    }

?>