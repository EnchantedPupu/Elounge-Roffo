<?php
    session_start();
    $_SESSION["user"] = "guest";
    header("Location: ../index.php");
    exit();
?>