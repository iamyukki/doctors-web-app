<?php 
    class Login{
        private $gender,$cat,$city;
        public function __construct($gender,$cat,$city) {
            $this->gender = $gender;
            $this->cat = $cat;
            $this->city = $city;
        }
    }
?>