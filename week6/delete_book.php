<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if(isset($_POST['confirm'])){
    $delete = $conn->prepare("DELETE FROM books WHERE id=?");
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
    <title>Delete Book – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">Delete Book</h1>

        <div class="card" style="width:50%; padding:30px;">
            <h2>Are you sure?</h2>
            <p>You are about to delete:</p>

            <strong><?= $book['title'] ?></strong><br>
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
