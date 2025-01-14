<?php
   /* define('DB_HOSTNAME', $_SERVER['DB_HOSTNAME'] ?? 'localhost');
    define('DB_USERNAME', $_SERVER['DB_USERNAME'] ?? 'elounge');
    define('DB_PASSWORD', $_SERVER['DB_PASSWORD'] ?? '123456');
    define('DB_DATABASE', $_SERVER['DB_DATABASE'] ?? 'elounge');*/
    define('DB_HOSTNAME', $_SERVER['DB_HOSTNAME'] ?? 'sql310.infinityfree.com');
    define('DB_USERNAME', $_SERVER['DB_USERNAME'] ?? 'if0_38042764');
    define('DB_PASSWORD', $_SERVER['DB_PASSWORD'] ?? 'Webapp001');
    define('DB_DATABASE', $_SERVER['DB_DATABASE'] ?? 'if0_38042764_elounge');

    function create_new_database_connection(): mysqli
    {
        return new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }
?>