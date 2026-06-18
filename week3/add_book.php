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
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO books (title, author, genre, price, stock, rating) 
            VALUES ('$title', '$author', '$genre', '$price', '$stock', '$rating')";
    if(mysqli_query($conn, $sql)){
        header("Location: books.php?success=1");
        exit();
    } else {
        $error = " Error adding book: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Book – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Add New Book</h1>

        <form method="POST" class="form-card">
            <label>Title</label>
            <input type="text" name="title" required>

            <label>Author</label>
            <input type="text" name="author" required>

            <label>Genre</label>
            <input type="text" name="genre" required>

            <label>Price</label>
            <input type="number" step="0.01" name="price" required>

            <label>Stock</label>
            <input type="number" name="stock" required>

            <label>Rating</label>
            <input type="number" step="0.1" max="5" name="rating" required>

            <button type="submit">Add Book</button>
        </form>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>

</html>