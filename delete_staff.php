<?php
include("config.php");
session_start();

if(!isset($_SESSION['admin_login'])){
    header("Location: admin_login.php");
    exit();
}

$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "DELETE FROM tbl_staff WHERE id='$id'";
mysqli_query($db, $sql);

header("Location: admin_dashboard.php");
exit();
?>