<?php
define('DB_SERVER', 'sql12.freesqldatabase.com');
define('DB_USERNAME', 'sql12829626');
define('DB_PASSWORD', 'tkb3DNHJw5');
define('DB_DATABASE', 'sql12829626');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

