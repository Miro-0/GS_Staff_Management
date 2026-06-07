<?php
include("config.php");
session_start();

// Security Gate: If the session variable isn't set, kick them back to login
if(!isset($_SESSION['staff_login'])){
    header("Location: staff_login.php");
    exit();
}

$staff_id = $_SESSION['staff_login'];
$staff = mysqli_query($db, "SELECT * FROM tbl_staff WHERE id='$staff_id'");
$user = mysqli_fetch_assoc($staff);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <style>
        body{ margin:0; padding:40px; background:#111827; color:white; font-family:Segoe UI; }
        .card{ background:rgba(255,255,255,0.08); padding:30px; border-radius:20px; margin-bottom:20px; }
        a{ display:inline-block; margin:10px 10px 10px 0; padding:12px 20px; border-radius:8px; background:#4CAF50; color:white; text-decoration:none; font-weight:bold; }
        .logout{ background:#ff4d4d; }
    </style>
</head>
<body>
<div class="card">
    <h1>Welcome, <?php echo htmlspecialchars($user['fullname']); ?></h1>
    <p>Department: <strong><?php echo htmlspecialchars($user['department']); ?></strong></p>
    <p>Role: <strong><?php echo htmlspecialchars($user['role']); ?></strong></p>
</div>

<div class="card">
    <h2>Workspace</h2>
    <a href="notes.php">Notes</a>
    <a href="projects.php">Projects</a>
    <a href="files.php">Files</a>
    <a class="logout" href="logout.php">Logout</a>
</div>
</body>
</html>