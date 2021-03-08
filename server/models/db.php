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
                $password = md5($password);
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

        public function get_plants($userId){
            $sql = "SELECT * FROM Plants";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $plants = [];

            while ($row = mysqli_fetch_array($result)) {
                $plant = Array("id"=> $row["Id"],"name"=> $row["Name"], "type"=>$row["Type"],
                    "color"=>  $row["Color"], "price"=> $row["Price"], "height"=> $row["Height"],
                    "rating"=> $row["Rating"], "description"=> $row["Description"], "url"=>$row["Url"]);
                $url = $plant["url"];
                $plant["url"] = "/plants-store/client/imgs/plants/$url.png";
                array_push($plants, $plant);
            }


            $sql = "SELECT PlantId FROM Orders WHERE UserId = $userId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $plantsInCart = [];

            while ($row = mysqli_fetch_array($result)) {
                $cartPlant = $row["PlantId"];
                array_push($plantsInCart, $cartPlant);
            }

            for($i = 0; $i < count($plants); $i++){
                for($j = 0; $j < count($plantsInCart); $j++){
                    $plants[$i] += ["inCart" => false];
                    if($plants[$i]["id"] === $plantsInCart[$j]){
                        $plants[$i]["inCart"] = true;
                    }
                }
            }

            $sql = "SELECT PlantId FROM Liked WHERE UserId = $userId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $likedPlants = [];

            while ($row = mysqli_fetch_array($result)) {
                $likedPlant = $row["PlantId"];
                array_push($likedPlants, $likedPlant);
            }

            for($i = 0; $i < count($plants); $i++){
                for($j = 0; $j < count($likedPlants); $j++){
                    $plants[$i] += ["liked" => false];
                    if($plants[$i]["id"] === $likedPlants[$j]){
                        $plants[$i]["liked"] = true;
                    }
                }
            }


            return $plants;
        }

        public function add_to_cart($userId, $plantId, $count){
            $sql = "INSERT INTO Orders (UserId, PlantId, Count) values ($userId, $plantId, $count)";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            if ($result){
                return true;
            }
            return false;
        }

        public function add_to_liked($userId, $plantId){
            $sql = "INSERT INTO Liked (UserId, PlantId) values ($userId, $plantId)";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            if ($result){
                return true;
            }
            return false;
        }

        public function get_plant($userId, $plantId){
            $sql = "SELECT * FROM Plants WHERE Id = $plantId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $plant = [];

            while ($row = mysqli_fetch_array($result)) {
                $plant = Array("id"=> $row["Id"],"name"=> $row["Name"], "type"=>$row["Type"],
                    "color"=>  $row["Color"], "price"=> $row["Price"], "height"=> $row["Height"],
                    "rating"=> $row["Rating"], "description"=> $row["Description"], "url"=>$row["Url"]);
                $url = $plant["url"];
                $plant["url"] = "/plants-store/client/imgs/plants/$url.png";
                break;
            }

            $sql = "SELECT PlantId FROM Liked WHERE UserId = $userId AND PlantId = $plantId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $count = mysqli_num_rows($result);
            if($count < 1)
                $plant += ["liked"=>false];
            else
                $plant += ["liked"=>true];

            $sql = "SELECT PlantId FROM Orders WHERE UserId = $userId AND PlantId = $plantId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $count = mysqli_num_rows($result);
            if($count < 1)
                $plant += ["inCart"=>false];
            else
                $plant += ["inCart"=>true];

            return Array("plant" => $plant);

        }

        public function get_blogs(){
            $sql = "SELECT * FROM Blogs";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $blogs = [];

            while ($row = mysqli_fetch_array($result)) {
                $blog = Array("id"=> $row["Id"],"title"=> $row["Title"], "preview"=>$row["Preview"],
                    "text"=>  $row["Text"], "url"=> $row["Url"]);
                $url = $blog["url"];
                $blog["url"] = "/plants-store/client/imgs/blogs/$url.jpg";
                array_push($blogs, $blog);
            }
            return $blogs;
        }

        public function get_blog($blogId){
            $sql = "SELECT * FROM Blogs WHERE Id = $blogId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $blogs = [];
            while ($row = mysqli_fetch_array($result)) {
                $blog = Array("id" => $row["Id"],"title" => $row["Title"], "preview" => $row["Preview"],
                    "text" =>  $row["Text"], "url" => $row["Url"]);
                $url = $blog["url"];
                $blog["url"] = "url('/plants-store/client/imgs/blogs/$url.jpg')";
                array_push($blogs, $blog);
            }
            return $blogs[0];
        }

        public function get_comments($blogId){
            $sql = "
                    SELECT c.Id, c.Text, u.Name
                    FROM Comments as c
                    JOIN Users as u ON u.Id = c.UserId
                    WHERE c.BlogId = $blogId
            ";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $comments = [];
            while ($row = mysqli_fetch_array($result)) {
                $comment = Array("id" => $row["Id"],"text" => $row["Text"], "senderName" => $row["Name"]);
                array_push($comments, $comment);
            }
            return $comments;

        }

        public function insert_comment($userId, $blogId, $text){
            $sql = "INSERT INTO Comments (UserId, BlogId, Text) values ($userId, $blogId, '$text')";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            if ($result){
                return true;
            }
            return false;
        }

        public function get_likedPlants($userId){
            $sql = "
                    SELECT p.Id, p.Name, p.Type, p.Color, p.Price, p.Height, p.Rating, p.Description, p.Url
                    FROM Plants as p
                    JOIN Liked as l ON p.Id = l.PlantId
                    WHERE l.UserId = $userId
            ";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));

            $plants = [];

            while ($row = mysqli_fetch_array($result)) {
                $plant = Array("id"=> $row["Id"],"name"=> $row["Name"], "type"=>$row["Type"],
                    "color"=>  $row["Color"], "price"=> $row["Price"], "height"=> $row["Height"],
                    "rating"=> $row["Rating"], "description"=> $row["Description"], "url"=>$row["Url"]);
                $url = $plant["url"];
                $plant["url"] = "/plants-store/client/imgs/plants/$url.png";
                array_push($plants, $plant);
            }

            return $plants;

        }

        public function get_personalInfo($userId){
            $sql = "SELECT * FROM Users WHERE Id = $userId";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            $users = [];
            while ($row = mysqli_fetch_array($result)) {
                $user = Array("id" => $row["Id"], "name" => $row["Name"], "email" => $row["Email"],
                    "address" =>  $row["Address"]);
                array_push($users, $user);
            }
            return $users[0];
        }

        public function remove_from_liked($plantId, $userId){
            $sql ="DELETE FROM Liked WHERE UserId = '$userId' AND PlantId = '$plantId'";
            $result = mysqli_query($this->link, $sql) or die("Error" . mysqli_error($this->link));
            return $result;
        }

    }
?>