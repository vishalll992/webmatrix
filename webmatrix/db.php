<?php
$host = 'localhost';     // Keep this as 'localhost' if running locally
$db   = 'origin';        // Your database name
$user = 'root';          // Default XAMPP/WAMP username
$pass = '';              // Default XAMPP/WAMP password is empty ('')

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional for debugging
echo "Connected successfully";
?>
