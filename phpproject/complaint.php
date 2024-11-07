<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    // Insert complaint into the database
    $sql = "INSERT INTO complaints (user_id, subject, description) VALUES ('$user_id', '$subject', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Redirect back to dashboard after submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Display error message if insertion fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Complaint</title>
</head>
<body>
<h2>Submit Complaint</h2>
<form method="post" action="complaint.php">

    <input type="text" name="subject" placeholder="Subject" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <button type="submit">Submit Complaint</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
