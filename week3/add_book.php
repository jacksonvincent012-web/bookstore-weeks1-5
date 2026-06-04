<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];

    $sql = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
    if(mysqli_query($conn, $sql)){
        header("Location: books.php");
        exit();
    } else {
        $error = "Error adding book!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
</head>
<body>
    <h2>➕ Add New Book</h2>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>
        <label>Author:</label><br>
        <input type="text" name="author" required><br><br>
        <button type="submit">Add Book</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <br><a href="books.php">⬅ Back to Books</a>
</body>
</html>
