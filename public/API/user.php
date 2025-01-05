<?php
    class User{
        private $conn;
        private $table_name = "users";

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
                return true;
            } else {
                return false;
            }
        }

        public function signup($name, $email, $password, $gender){
            $isadmin = 0;
            $profile_picture = "default.jpg";
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


        // public function signup($name, $email, $password, $gender){

    }
?>