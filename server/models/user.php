<?php


    class User
    {
        public $name;
        public $login;
        public $email;
        public $address;
        public $password;

        function __construct($name, $login, $email, $address, $password){
            $this->name = $name;
            $this->login = $login;
            $this->email = $email;
            $this->address = $address;
            $this->password = md5($password);
        }
    }
?>