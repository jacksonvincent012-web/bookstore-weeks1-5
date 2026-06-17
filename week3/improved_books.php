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
    <title>Improved Books – PageTurn</title>
    <link rel="stylesheet" href="style.css">
    <style>
    /* Modern low stock styling (soft amber glass instead of red) */
    .low-stock {
        background: rgba(255, 193, 7, 0.15);
        /* soft amber glass */
        backdrop-filter: blur(6px);
        color: #b36b00;
        /* warm amber text */
        font-weight: bold;
        border-left: 4px solid #ffc107;
        /* amber accent stripe */
    }

    .success-msg {
        color: green;
        font-weight: bold;
    }

    .info-msg {
        color: blue;
        font-weight: bold;
    }

    /* Delete button stays red */
    .delete-btn {
        color: #fff;
        background: #d9534f;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    .edit-btn {
        color: #fff;
        background: #007bff;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .edit-btn:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Improved Books View</h1>

        <!-- Feedback banners -->
        <?php if(isset($_GET['deleted'])): ?>
        <p class="success-msg"> Book deleted successfully!</p>
        <?php elseif(isset($_GET['updated'])): ?>
        <p class="info-msg"> Book updated successfully!</p>
        <?php elseif(isset($_GET['success'])): ?>
        <p class="success-msg"> Book added successfully!</p>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr class="<?= ($row['stock'] < 10 ? 'low-stock' : '') ?>">
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['genre'] ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['rating'] ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a>
                    <a href="delete_book.php?id=<?= $row['id'] ?>" class="delete-btn"> Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <!-- Pagination placeholder -->
        <p style="margin-top:15px; font-weight:bold;">Page 1 of 1 · <?= mysqli_num_rows($result) ?> results</p>
    </div>
</body>

</html>