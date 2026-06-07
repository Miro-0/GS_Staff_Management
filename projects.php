<?php
include("config.php");
session_start();

if(!isset($_SESSION['staff_login'])){
    header("Location: staff_dashboard.php");
    exit();
}

$staff_id = $_SESSION['staff_login'];

if(isset($_POST['add'])){
    $project = mysqli_real_escape_string($db, $_POST['project']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $progress = mysqli_real_escape_string($db, $_POST['progress']);
    $deadline = mysqli_real_escape_string($db, $_POST['deadline']);

    mysqli_query($db, "INSERT INTO tbl_projects (staff_id, project_name, description, progress, deadline) VALUES ('$staff_id', '$project', '$description', '$progress', '$deadline')");
    header("Location: projects.php");
    exit();
}

$projects = mysqli_query($db, "SELECT * FROM tbl_projects WHERE staff_id='$staff_id' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
    <style>
        body{ font-family:Segoe UI; background:#111827; color:white; padding:40px; }
        input, textarea, select{ width:100%; max-width:500px; padding:12px; margin:10px 0; border:none; border-radius:8px; display:block; box-sizing: border-box; }
        button{ padding:12px 24px; border:none; border-radius:8px; background:#4CAF50; color:white; cursor:pointer; font-weight:bold; }
        .project-box{ background: rgba(255,255,255,0.05); padding:20px; border-radius:12px; margin-top:20px; max-width:500px; border-left:5px solid #4CAF50; }
        a{ color:#4CAF50; text-decoration:none; display:inline-block; margin-bottom:20px; }
        label{ font-size:14px; color:#aaa; }
    </style>
</head>
<body>
    <a href="staff_dashboard.php">← Dashboard</a>
    <h1>🚀 Project Management logs</h1>

    <form method="post">
        <input type="text" name="project" placeholder="Project Name" required>
        <textarea name="description" placeholder="Description details..."></textarea>
        
        <label>Project Timeline Deadline:</label>
        <input type="date" name="deadline" required>

        <label>Current Status Progress:</label>
        <select name="progress">
            <option>0%</option>
            <option>25%</option>
            <option>50%</option>
            <option>75%</option>
            <option>100%</option>
        </select>
        <button type="submit" name="add">Add Project Record</button>
    </form>

    <hr style="margin:40px 0; border-color:rgba(255,255,255,0.1);">

    <?php while($row = mysqli_fetch_assoc($projects)){ ?>
        <div class="project-box">
            <h2><?php echo htmlspecialchars($row['project_name']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            <p><strong>Progress Metrics:</strong> <?php echo $row['progress']; ?></p>
            <p><small>⏱ Deadline: <?php echo $row['deadline']; ?></small></p>
        </div>
    <?php } ?>
</body>
</html>