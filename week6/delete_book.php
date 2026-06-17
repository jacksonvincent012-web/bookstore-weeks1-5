<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("No book ID provided.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if(!$book){
    die("Book not found.");
}

if(isset($_POST['confirm'])){
    $delete = $conn->prepare("DELETE FROM books WHERE id = ?");
    $delete->bind_param("i", $id);
    if($delete->execute()){
        header("Location: books.php?deleted=1");
        exit();
    } else {
        $error = "Error deleting book: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Book - PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1 class="page-title">Delete Book</h1>
        <div class="card" style="width:50%; padding:30px;">
            <h2>Are you sure?</h2>
            <p>You are about to delete:</p>
            <strong><?= htmlspecialchars($book['title']) ?></strong><br>
            <small>by <?= htmlspecialchars($book['author']) ?></small><br>
            <small>Genre: <?= $book['genre'] ?> | Price: $<?= $book['price'] ?> | Stock: <?= $book['stock'] ?> | Rating: <?= $book['rating'] ?></small>
            <br><br>
            <form method="POST">
                <button type="submit" name="confirm" style="background:#d9534f; padding:10px 20px; border:none; border-radius:6px; color:#fff; font-weight:bold; cursor:pointer;">Yes, Delete</button>
                <a href="books.php" class="btn" style="background:#6c757d; padding:10px 20px; border-radius:6px; color:#fff; text-decoration:none;">Cancel</a>
            </form>
            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
    </div>
</body>
</html>
