<?php


    class EmailSender
    {
        public $to = "ultragreen555@gmail.com";
        public $headers = "Content-Type: text/html;";

        public function sendMessage($name, $email, $phone, $subject ,$message){
            $totalMessage = "
            Name: $name\n\n
            Email: $email\n\n
            Phone: $phone\n\n
            Message: $message\n\n
            ";

            $send = mail($this->to, $subject, $totalMessage, $this->headers);
            return $send;
        }

        public function sendOrder($plants_list, $sum, $name, $email, $address){

            $plants_str = "\n\n";

            for($i = 0; $i < count($plants_list); $i++){
                $str = "Name:" . $plants_list[$i]["name"] . "\n\n" . "Count:" . $plants_list[$i]["count"] . "\n\n";
                $plants_str .= $str;
            }

            $message = "
                Name: $name\n
                Email: $email\n
                Address: $address\n
                Total sum: $sum\n\n
                Plants list:\n
                $plants_str
            ";

            $send = mail($this->to, "Order", $message, $this->headers);
            return $send;
        }
    }
?>