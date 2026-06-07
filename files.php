<?php
include("config.php");
session_start();

if(!isset($_SESSION['staff_login'])){
    header("Location: staff_dashboard.php");
    exit();
}

$staff_id = $_SESSION['staff_login'];

if(isset($_POST['upload'])){
    if(!is_dir('uploads')){
        mkdir('uploads', 0777, true);
    }

    $filename = time() . "_" . basename($_FILES['file']['name']);
    $tmp = $_FILES['file']['tmp_name'];
    $path = "uploads/" . $filename;

    if(move_uploaded_file($tmp, $path)){
        $original_name = mysqli_real_escape_string($db, $_FILES['file']['name']);
        $secure_path = mysqli_real_escape_string($db, $path);
        mysqli_query($db, "INSERT INTO tbl_files (staff_id, filename, filepath) VALUES ('$staff_id', '$original_name', '$secure_path')");
    }
}

$files = mysqli_query($db, "SELECT * FROM tbl_files WHERE staff_id='$staff_id' ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Files</title>
    <style>
        body{ font-family:Segoe UI; background:#111827; color:white; padding:40px; }
        button{ padding:10px 20px; border:none; border-radius:6px; background:#4CAF50; color:white; cursor:pointer; font-weight:bold; }
        a{ color:#4CAF50; text-decoration:none; display:inline-block; margin-bottom:20px; }
    </style>
</head>
<body>
    <a href="staff_dashboard.php">← Dashboard</a>
    <h1>📁 Project Files Repository</h1>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <br><br>
        <button type="submit" name="upload">Upload File</button>
    </form>

    <hr style="margin:30px 0; border-color:rgba(255,255,255,0.1);">

    <?php while($row = mysqli_fetch_assoc($files)){ ?>
        <p>
            📎 <a href="<?php echo htmlspecialchars($row['filepath']); ?>" target="_blank">
                <?php echo htmlspecialchars($row['filename']); ?>
            </a>
        </p>
    <?php } ?>
</body>
</html>