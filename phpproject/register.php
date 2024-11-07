<?php
// register.php
include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Validate that the passwords match
    if ($password !== $confirm_password) {
        echo "<p class='error-message'>Passwords do not match. Please try again.</p>";
    } else {
        // Check if the username or email already exists
        $checkUser = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = $conn->query($checkUser);
        
        if ($result->num_rows > 0) {
            echo "<p class='error-message'>Username or email already exists. Please choose another.</p>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php"); // Redirect to login page after successful registration
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error; // Display error message if insertion fails
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to CSS -->
</head>
<body>
<div class="container">
<h2>Register</h2>
<form method="post" action="">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br> <!-- Confirm Password Field -->
    <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login here.</a>
</div>
</body>
</html>
