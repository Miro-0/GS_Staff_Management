<?php
session_start();
include("config.php");
$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM tbl_admin WHERE username='$username'";
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $passwordMatch = password_verify($password, $row['password']) || ($password === $row['password']);
        if($passwordMatch){
            $_SESSION['admin_login'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid Password";
        }
    } else {
        $error = "Invalid Username";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body{ margin:0; height:100vh; display:flex; justify-content:center; align-items:center; background:#0f172a; font-family:Segoe UI; }
        .container{ width:350px; padding:40px; background:rgba(255,255,255,0.08); border-radius:20px; color:white; text-align:center; }
        input{ width:100%; padding:12px; margin:10px 0; border:none; border-radius:8px; box-sizing: border-box; }
        button{ width:100%; padding:12px; border:none; border-radius:8px; background:#7c4dff; color:white; cursor:pointer; }
        .err{ color:#ff6b6b; }
        .link{ display:block; margin-top:15px; color:#7c4dff; text-decoration:none; font-size:14px; }
    </style>
</head>
<body>
<div class="container">
    <h1>🎮 Admin Login</h1>
    <p class="err"><?php echo $error; ?></p>
    <form method="post">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a class="link" href="staff_dashboard.php">Switch to Staff Portal</a>
</div>
</body>
</html>