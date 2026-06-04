<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM books WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: books.php");
    exit();
} else {
    echo "Error deleting book!";
}
?>
