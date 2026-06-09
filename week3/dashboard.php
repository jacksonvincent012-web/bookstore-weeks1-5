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
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        margin: 0;
        padding: 0;
        color: #003366;
        display: flex;
    }

    .main {
        flex: 1;
        padding: 40px;
    }

    h1.page-title {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    th {
        background: rgba(255, 255, 255, 0.4);
        font-weight: bold;
    }

    /* Make titles & authors black and elegant */
    td:nth-child(2),
    td:nth-child(3) {
        color: #000;
        /* pure black */
        font-weight: 500;
        /* medium weight */
        letter-spacing: 0.5px;
        /* subtle spacing */
    }

    /* Low stock styling */
    .low-stock {
        background: rgba(255, 193, 7, 0.15);
        backdrop-filter: blur(6px);
        color: #b36b00;
        font-weight: bold;
        border-left: 4px solid #ffc107;
    }

    /* Buttons */
    .delete-btn,
    .edit-btn {
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-btn {
        background: #d9534f;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    .edit-btn {
        background: #007bff;
    }

    .edit-btn:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">📘 Improved Books View</h1>

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
            <tr class="<?= (!empty($row['stock']) && $row['stock'] < 10 ? 'low-stock' : '') ?>">
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['genre'] ?: '—' ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?: '—' ?></td>
                <td><?= $row['rating'] ?: '—' ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
                    <a href="delete_book.php?id=<?= $row['id'] ?>" class="delete-btn">🗑 Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>