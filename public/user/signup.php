<?php
    include_once "../../utils.php";
    include_once "../API/user.php";

    $is_post_request = $_SERVER["REQUEST_METHOD"] === "GET";

    $name = "User";
    $email = $_GET["email"] ?? false;
    $password = password_hash($_GET["password"], PASSWORD_DEFAULT);
    $isadmin = 0;
    $gender = $_GET["gender"] ?? false;
    $profile_picture = "default.jpg";

    if ($is_post_request) {
        $db = create_new_database_connection();
        $user = new User($db);
        if($user->signup($name, $email, $password, $gender)){
            header('Content-Type: application/json');
            echo json_encode(array("message" => "success"));
        } else {
            echo json_encode(array("message" => "failed"));
        }
    }
?>