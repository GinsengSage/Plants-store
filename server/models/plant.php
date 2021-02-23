<?php
    class Plant
    {
        public $id;
        public $name;
        public $type;
        public $color;
        public $price;
        public $height;
        public $rating;
        public $description;
        public $url;

        function __construct($id ,$name, $type, $color, $price, $height, $rating, $description, $url){
            $this->id = $id;
            $this->name = $name;
            $this->type = $type;
            $this->color = $color;
            $this->price = $price;
            $this->height = $height;
            $this->rating = $rating;
            $this->description = $description;
            $this->url = $url;
        }
    }
?>