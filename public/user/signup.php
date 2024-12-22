<?php
    include_once "../../utils.php";

    $is_post_request = $_SERVER["REQUEST_METHOD"] === "POST";

    $name = $_POST["name"] ?? false;
    $email = $_POST["email"] ?? false;
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT) ?? false; //password_verify($password, $hash)
    $isadmin = 0;
    $gender = $_POST["gender"] ?? false;
    $profile_picture = "default.jpg";

    if ($is_post_request) {
        if($name && $email && $password && $gender){
            $database = create_new_database_connection();
            $query = "INSERT INTO users (name, email, password, isadmin, gender, profile_pic) VALUES ('$name', '$email', '$password', $isadmin, '$gender', '$profile_picture')";
            $database->query($query);
            echo json_encode(["message" => "User created successfully"]);
            session_start();
            $_SESSION["user"] = $name;
         } else {
            echo json_encode(["message" => "User not created"]);
        }
    }
?>