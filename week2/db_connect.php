<?php
// Database connection for PageTurn Bookstore System

$conn = mysqli_connect("localhost", "root", "", "bookstoredb");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>