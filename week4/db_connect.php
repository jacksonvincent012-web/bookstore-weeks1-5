<?php
$servername = "localhost";   // Always localhost in XAMPP
$username   = "root";        // Default MySQL username
$password   = "";            // Default MySQL password is empty
$dbname     = "bookstoredb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
