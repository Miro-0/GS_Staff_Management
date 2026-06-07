<?php
include("config.php");
session_start();

if(!isset($_SESSION['admin_login'])){
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM tbl_staff";
$result = mysqli_query($db, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body{ margin:0; padding:40px; background:#0f172a; color:white; font-family:Segoe UI; }
        table{ width:100%; border-collapse:collapse; margin-top:20px; }
        th,td{ border:1px solid rgba(255,255,255,0.1); padding:15px; text-align:center; }
        th{ background:#7c4dff; }
        a{ padding:8px 14px; border-radius:6px; text-decoration:none; color:white; }
        .edit{ background:#4CAF50; }
        .delete{ background:#ff4d4d; }
        .top{ background:#7c4dff; display:inline-block; margin-bottom:20px; margin-right:10px; }
    </style>
</head>
<body>
    <h1>🎮 Admin Dashboard</h1>
    <a class="top" href="create_staff.php">Add Staff Account</a>
    <a class="top" href="logout.php">Logout</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Department</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a class="edit" href="update_staff.php?id=<?php echo $row['id']; ?>">Update</a>
                <a class="delete" href="delete_staff.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>