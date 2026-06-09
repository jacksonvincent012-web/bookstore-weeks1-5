<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Fetch book details for confirmation
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);

// If user confirms deletion
if(isset($_POST['confirm'])){
    $delete = "DELETE FROM books WHERE id=$id";
    if(mysqli_query($conn, $delete)){
        header("Location: books.php?deleted=1");
        exit();
    } else {
        $error = "❌ Error deleting book: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Book – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">🗑 Delete Book</h1>

        <div class="card" style="width:50%; padding:30px;">
            <h2>Are you sure?</h2>
            <p>You are about to delete:</p>

            <strong>📘 <?= $book['title'] ?></strong><br>
            <small>by <?= $book['author'] ?></small><br>
            <small>Genre: <?= $book['genre'] ?> | Price: $<?= $book['price'] ?> | Stock: <?= $book['stock'] ?> | Rating:
                <?= $book['rating'] ?></small>

            <br><br>

            <form method="POST">
                <button type="submit" name="confirm" style="background:#d9534f;">Yes, Delete</button>
                <a href="books.php" class="btn" style="background:#6c757d;">Cancel</a>
            </form>

            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
    </div>
</body>

</html>