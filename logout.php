<?php
session_start();
session_destroy();
header("Location: staff_dashboard.php");
exit();
?>