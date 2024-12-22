<?php
    include_once "../API/user.php";
    include_once "../../utils.php";

    $database = create_new_database_connection();

    $user = new User($database);

    $is_post_request = $_SERVER["REQUEST_METHOD"] === "POST";
    $email = $_POST["email"] ?? false;
    $password = $_POST["password"] ?? false;

    if ($is_post_request) {
        if($email && $password){
            if($user->login($email, $password)){
                echo json_encode(["message" => "Login successful"]);
                header("Location: ../index.php");
            } else {
                echo json_encode(["message" => "Login failed - Invalid email or password"]);
                header("Location: /testsignup.php");
            }
        } else {
            echo json_encode(["message" => "There are missing fields"]);
        }
    }

?>