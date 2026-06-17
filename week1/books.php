<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Books – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div class="main">

        <h1 class="page-title"> Books</h1>

        <a href="add_book.php" class="btn"> Add Book</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td>
                    <a class="btn" href="edit_book.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn" href="delete_book.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>

    </div>

</body>

</html>