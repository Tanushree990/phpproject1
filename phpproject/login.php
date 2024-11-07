<?php
// login.php
session_start(); // Start a new session or resume the existing session
include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find user by username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            $_SESSION['role'] = $row['role'];   // Store user role in session (if applicable)
            header("Location: dashboard.php"); // Redirect to dashboard after successful login
            exit();
        } else {
            echo "<p class='error-message'>Invalid password.</p>"; // Password mismatch error message
        }
    } else {
        echo "<p class='error-message'>No user found.</p>"; // No user found error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to CSS -->
</head>
<body>
<div class="container">
<h2>Login</h2>
<form method="post" action="">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<a href="register.php">Don't have an account? Register here.</a>
</div>
</body>
</html>
