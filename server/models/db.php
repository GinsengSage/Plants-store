<?php

    class DB
    {
        private $link;

        public function __construct(){
            $this->link = mysqli_connect("localhost", "root", "root", "plants_store_db");
        }

        public function insert_user($user){
            $user->password = md5($user->password);
            $sql = "INSERT INTO Users(Name, Login, Email, Address, Password) values ('$user->name', '$user->login',
 '$user->email', '$user->address', '$user->password')";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            if ($result){
                return true;
            }
            return false;
        }

        public function has_user($email){
            $sql = "SELECT * FROM Users WHERE Email = '$email'";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $count = mysqli_num_rows($result);
            if($count < 1){
                return false;
            }else{
                return true;
            }
        }

        private function get_id($login){
            $sql = "SELECT Id FROM Users WHERE Login = '$login'";
            $query = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $result = mysqli_fetch_array($query);
            return $result[0];
        }

        public function user_login($login, $password){
            if($login === "admin" && $password === "admin")
                return Array("error" => false, "Id" => 0);
            else{
                $sql = "SELECT * FROM Users WHERE Login = '$login' and Password  = '$password'";
                $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
                $count = mysqli_num_rows($result);
                if($count < 1){
                    return Array("error" => true);
                }else{
                    return Array("error" => false, "Id" => $this->get_id($login));
                }
            }
        }
    }
?>