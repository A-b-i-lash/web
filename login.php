<?php
$servername = "localhost";
$db_username = "your_db_username";
$db_password = "your_db_password";
$dbname = "your_db_name";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashedPassword);
$stmt->fetch();

// Verify the password
if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
    echo "Login successful!";
    // Redirect to a dashboard or another page
    // header("Location: dashboard.php");
} else {
    echo "Invalid username or password.";
}

// Close connections
$stmt->close();
$conn->close();
?>
