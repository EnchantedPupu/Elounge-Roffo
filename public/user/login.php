<?php
    include_once "../API/user.php";
    include_once "../../utils.php";

    $database = create_new_database_connection();

    $user = new User($database);

    $is_post_request = $_SERVER["REQUEST_METHOD"] === "GET";
    $email = $_GET["email"] ?? false;
    $password = $_GET["password"] ?? false;

    if ($is_post_request) {
        if($email && $password){
            if($user->login($email, $password)){
                header('Content-Type: application/json');
                echo json_encode(array("message" => "success"));
            } else {
                header('Content-Type: application/json');
                echo json_encode(array("message" => "failed"));
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(["message" => "There are missing fields"]);
        }
    }

?>