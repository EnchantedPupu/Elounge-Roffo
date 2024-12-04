<?php
    include_once "../../utils.php";

    $database = create_new_database_connection();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //GET ALL USERS
        $query = "SELECT * FROM users";
        $result = $database->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
    }
?>