<?php
include("config.php");
session_start();
$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    // Checks your exact schema where status defaults to 'Active'
    $sql = "SELECT * FROM tbl_staff WHERE username='$username' AND status='Active'";
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        
        // Verifies the hashed password from registration
        if(password_verify($password, $row['password'])){
            // Saves the numeric staff ID to the session for tracking notes/files/projects
            $_SESSION['staff_login'] = $row['id']; 
            header("Location: staff_dashboard.php");
            exit();
        } else {
            $error = "Invalid Password.";
        }
    } else {
        $error = "Invalid Username or account is inactive.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <style>
        body{ margin:0; height:100vh; display:flex; justify-content:center; align-items:center; background:#111827; font-family:Segoe UI; color:white; }
        .container{ width:350px; padding:40px; background:rgba(255,255,255,0.08); border-radius:20px; text-align:center; box-sizing: border-box; }
        input{ width:100%; padding:12px; margin:10px 0; border:none; border-radius:8px; box-sizing: border-box; }
        button{ width:100%; padding:12px; border:none; border-radius:8px; background:#4CAF50; color:white; cursor:pointer; font-weight:bold; }
        .err{ color:#ff6b6b; }
        a{ color:#4CAF50; text-decoration:none; display:block; margin-top:15px; font-size:14px; }
    </style>
</head>
<body>
<div class="container">
    <h1>👨‍💻 Staff Login</h1>
    <p class="err"><?php echo $error; ?></p>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="create_staff.php">Sign Up / Register New Account</a>
    <a href="admin_login.php" style="color:#aaa; font-size:12px;">Go to Admin Portal</a>
</div>
</body>
</html>