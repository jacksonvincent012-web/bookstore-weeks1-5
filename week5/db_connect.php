<?php
// Database connection for PageTurn Bookstore System

$servername = "localhost";   // or "127.0.0.1:3307" if MySQL runs on port 3307
$username   = "root";        // default XAMPP user
$password   = "";            // empty by default
$dbname     = "bookstoredb"; // make sure this database exists in phpMyAdmin

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die(" Database Connection Failed: " . mysqli_connect_error());
}
?>