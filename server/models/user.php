<?php

    class User
    {
        public $id;
        public $name;
        public $login;
        public $email;
        public $address;
        public $password;

        function __construct($id, $name, $login, $email, $address, $password)
        {
            $this->id = $id;
            $this->name = $name;
            $this->login = $login;
            $this->email = $email;
            $this->address = $address;
            $this->password = $password;
        }
    }

?>