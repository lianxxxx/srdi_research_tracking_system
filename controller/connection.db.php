<?php
// Database credentials
$host = "localhost";   // usually 'localhost'
$user = "root";        // default XAMPP username
$pass = "";            // default XAMPP password (empty unless you set one)
$db   = "srdi_research_tracking"; // your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment to test connection
?>
