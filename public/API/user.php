<?php
    class User{
        public $conn;
        private $table_name = "users";
        //private $name, $email, $password, $matric, $isadmin, $gender, $profile_picture;

        public function __construct($db){
            $this->conn = $db;
        }
        public function login($email, $password){
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = '$email'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            if(password_verify($password, $row["password"])){
                session_start();
                $_SESSION["user"] = $row["name"];
                $_SESSION["email"] = $row["email"];
                if($row["isadmin"] == 1){
                    $_SESSION["user"] = "admin";
                } 
                return true;
            } else {
                return false;
            }
        }

        public function getUserInfo($email){
            $id = $this->getIdFromEmail($email);
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = $id";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            return $row;
        }

        public function signup($name, $email, $password, $gender){
            $isadmin = 0;
            $profile_picture = "default.png";
            if($this->checkExistingUser($email)){
                return false;
            }
            $query = "INSERT INTO " . $this->table_name . " (name, email, password, isadmin, gender, profile_pic) VALUES ('$name', '$email', '$password', $isadmin, '$gender', '$profile_picture')";
            $this->conn->query($query);
            session_start();
            $_SESSION["user"] = $name;
            $_SESSION["email"] = $email;
            return true;
        }

        public function checkExistingUser($email){
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = '$email'";
            $result = $this->conn->query($query);
            if($result->num_rows > 0){
                return true;
            } else {
                return false;
            }
        }
        public function getIdFromEmail($email){
            $query = "SELECT id FROM " . $this->table_name . " WHERE email = '$email'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            return $row["id"];
        }

        public function updateUserProfile($email, $name, $newEmail, $faculty, $matric, $phone, $block, $bio, $profile_pic) {
            $query = "UPDATE " . $this->table_name . " SET name = ?, email = ?, faculty = ?, matric = ?, phone = ?, residential = ?, bio = ?, profile_pic = ? WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssssss", $name, $newEmail, $faculty, $matric, $phone, $block, $bio, $profile_pic, $email);
            if ($stmt->execute()) {
                $_SESSION["user"] = $name;
                $_SESSION["email"] = $newEmail;
                return true;
            } else {
                return false;
            }
        }

    }
?>