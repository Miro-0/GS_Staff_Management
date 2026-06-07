<?php
include("config.php");
session_start();

if(!isset($_SESSION['staff_login'])){
    header("Location: staff_dashboard.php");
    exit();
}

$staff_id = $_SESSION['staff_login'];

if(isset($_POST['add_note'])){
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $note = mysqli_real_escape_string($db, $_POST['note']);

    mysqli_query($db, "INSERT INTO tbl_notes (staff_id, title, note) VALUES ('$staff_id', '$title', '$note')");
    header("Location: notes.php");
    exit();
}

$notes = mysqli_query($db, "SELECT * FROM tbl_notes WHERE staff_id='$staff_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notes</title>
    <style>
        body{ font-family:Segoe UI; background:#111827; color:white; padding:40px; }
        input, textarea{ width:100%; max-width:500px; padding:12px; margin:10px 0; border:none; border-radius:8px; display:block; box-sizing: border-box; }
        button{ padding:12px 24px; border:none; border-radius:8px; background:#4CAF50; color:white; cursor:pointer; font-weight:bold; }
        .note-card{ background:rgba(255,255,255,0.05); padding:20px; border-radius:10px; margin-top:20px; max-width:500px; }
        a{ color:#4CAF50; text-decoration:none; display:inline-block; margin-bottom:20px; }
    </style>
</head>
<body>
    <a href="staff_dashboard.php">← Dashboard</a>
    <h1>📝 Workspace Notes</h1>

    <form method="post">
        <input type="text" name="title" placeholder="Note Title" required>
        <textarea name="note" rows="5" placeholder="Write note content here..." required></textarea>
        <button type="submit" name="add_note">Save Note</button>
    </form>

    <hr style="margin-top:40px; border-color:rgba(255,255,255,0.1);">

    <h2>Saved Workspace Entries</h2>
    <?php while($row = mysqli_fetch_assoc($notes)){ ?>
        <div class="note-card">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($row['note'])); ?></p>
            <small style="color:#aaa;"><?php echo $row['created_at']; ?></small>
        </div>
    <?php } ?>
</body>
</html>