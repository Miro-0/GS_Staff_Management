<?php
define('DB_SERVER', '192.168.100.28');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'gamingstudio');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>