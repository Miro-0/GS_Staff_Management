<?php
include("config.php");
session_start();

if(!isset($_SESSION['admin_login'])){
    header("Location: admin_login.php");
    exit();
}

$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "SELECT * FROM tbl_staff WHERE id='$id'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $department = $_POST['department'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $password = $_POST['password'];

    if(!empty($password)){
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE tbl_staff SET fullname='$fullname', username='$username', password='$hashed', department='$department', role='$role', status='$status' WHERE id='$id'";
    } else {
        $update = "UPDATE tbl_staff SET fullname='$fullname', username='$username', department='$department', role='$role', status='$status' WHERE id='$id'";
    }

    if(mysqli_query($db, $update)){
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Update failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Staff</title>
    <style>
        body{ margin:0; height:100vh; display:flex; justify-content:center; align-items:center; background:#0f172a; font-family:Segoe UI; color:white; }
        .container{ width:400px; padding:40px; background:rgba(255,255,255,0.08); border-radius:20px; box-sizing: border-box; }
        input,select{ width:100%; padding:12px; margin:10px 0; border:none; border-radius:8px; box-sizing: border-box; }
        option{ color:black; }
        button{ width:100%; padding:12px; border:none; border-radius:8px; background:#7c4dff; color:white; cursor:pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Staff</h2>
    <p style="color:#ff6b6b;"><?php echo $error; ?></p>
    <form method="post">
        <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required>
        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
        <input type="password" name="password" placeholder="New Password (Optional)">
        <select name="department">
            <option selected><?php echo $row['department']; ?></option>
            <option>Game Development</option>
            <option>UI/UX Design</option>
            <option>3D Modeling</option>
            <option>Marketing</option>
            <option>QA Testing</option>
        </select>
        <select name="role">
            <option selected><?php echo $row['role']; ?></option>
            <option>Developer</option>
            <option>Artist</option>
            <option>Moderator</option>
            <option>Tester</option>
            <option>Manager</option>
        </select>
        <select name="status">
            <option selected><?php echo $row['status']; ?></option>
            <option>Active</option>
            <option>Inactive</option>
        </select>
        <button type="submit">Update Staff</button>
    </form>
</div>
</body>
</html>