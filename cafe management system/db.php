<?php
// Database Configuration
$host = "localhost";      // Usually 'localhost'
$user = "root";           // Your MySQL username
$pass = "";               // Your MySQL password (agar set hai, yahan likho)
$db   = "cafe";           // Database name

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("❌ Connection Failed: " . mysqli_connect_error());
}

// Optional: success message for testing
// echo "✅ Database Connected Successfully!";
?>
