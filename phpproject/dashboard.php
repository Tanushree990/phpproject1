<?php
// dashboard.php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM complaints WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to CSS -->
</head>
<body>

<div class="container">
<h2>Your Complaints</h2>

<table border="1">
<tr>
<th>ID</th><th>Subject</th><th>Description</th><th>Status</th></tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($row['id']); ?></td>
<td><?php echo htmlspecialchars($row['subject']); ?></td>
<td><?php echo htmlspecialchars($row['description']); ?></td>
<td><?php echo htmlspecialchars($row['status']); ?></td></tr>

<?php endwhile; ?>
</table>

<h3>Submit a New Complaint:</h3>

<form method="post" action="complaint.php">
<input type="text" name="subject" placeholder="Subject" required><br>
<textarea name="description" placeholder="Description" required></textarea><br>
<button type="submit">Submit Complaint</button></form>

<a href="logout.php">Logout</a>

</div>

</body>
</html>
