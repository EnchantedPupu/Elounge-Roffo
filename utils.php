<?php
    define('DB_HOSTNAME', $_SERVER['DB_HOSTNAME'] ?? 'localhost');
    define('DB_USERNAME', $_SERVER['DB_USERNAME'] ?? 'elounge');
    define('DB_PASSWORD', $_SERVER['DB_PASSWORD'] ?? '123456');
    define('DB_DATABASE', $_SERVER['DB_DATABASE'] ?? 'elounge');

    function create_new_database_connection(): mysqli
    {
        return new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }
?>