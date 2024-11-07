<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch the complaint details based on ID
if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];
    $sql = "SELECT * FROM complaints WHERE id='$complaint_id'";
    $result = $conn->query($sql);
    $complaint = $result->fetch_assoc();
} else {
    header("Location: dashboard.php");
    exit();
}

// Update complaint status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    
    $sql = "UPDATE complaints SET status='$status' WHERE id='$complaint_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating complaint: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Complaint</title>
</head>
<body>
<h2>Update Complaint</h2>
<link rel="stylesheet" type="text/css" href="css/style.css">

<form method="post" action="">
    <label for="subject">Subject:</label><br>
    <input type="text" name="subject" value="<?php echo htmlspecialchars($complaint['subject']); ?>" disabled><br>

    <label for="description">Description:</label><br>
    <textarea name="description" disabled><?php echo htmlspecialchars($complaint['description']); ?></textarea><br>

    <label for="status">Status:</label><br>
    <select name="status">
        <option value="Pending" <?php if ($complaint['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Resolved" <?php if ($complaint['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
    </select><br>

    <button type="submit">Update Status</button>
</form>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
