<?php
include("config.php");
session_start();
$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    $check = "SELECT * FROM tbl_staff WHERE username='$username'";
    $result = mysqli_query($db, $check);

    if(mysqli_num_rows($result) > 0){
        $error = "Username already exists.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_staff (fullname, username, password, department, role, status) VALUES ('$fullname', '$username', '$hashed', '$department', '$role', 'Active')";

        if(mysqli_query($db, $sql)){
            if(isset($_SESSION['admin_login'])){
                header("Location: admin_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $error = "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Staff</title>
    <style>
        body{ margin:0; font-family:Segoe UI; background:linear-gradient(135deg,#120b25,#1f1f3d,#0f2027); display:flex; justify-content:center; align-items:center; height:100vh; }
        .container{ width:380px; padding:40px; background:rgba(255,255,255,0.08); backdrop-filter:blur(15px); border-radius:20px; color:white; box-sizing: border-box; }
        input,select{ width:100%; padding:12px; margin:10px 0; border:none; border-radius:8px; background:rgba(255,255,255,0.1); color:white; box-sizing: border-box; }
        option{ color:black; }
        button{ width:100%; padding:12px; border:none; border-radius:8px; background:#7c4dff; color:white; font-weight:bold; cursor:pointer; }
        .err{ color:#ff6b6b; }
        a{ color:#7c4dff; text-decoration:none; }
    </style>
</head>
<body>
<div class="container">
    <h2>🎮 Create Staff Account</h2>
    <p class="err"><?php echo $error; ?></p>
    <form method="post">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="department">
            <option>Game Development</option>
            <option>UI/UX Design</option>
            <option>3D Modeling</option>
            <option>Marketing</option>
            <option>QA Testing</option>
        </select>
        <select name="role">
            <option>Developer</option>
            <option>Artist</option>
            <option>Moderator</option>
            <option>Tester</option>
            <option>Manager</option>
        </select>
        <button type="submit">Create Staff</button>
        <p style="margin-top:15px;">
            Already have an account? <a href="staff_dashboard.php">Login here</a>
        </p>
    </form>
</div>
</body>
</html>