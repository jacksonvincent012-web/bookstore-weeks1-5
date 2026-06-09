<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Search functionality
$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM books";
}
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Books - PageTurn</title>
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

    h2 {
        margin: 20px 0;
        text-align: center;
        font-weight: bold;
        color: #003366;
    }

    /* Search bar */
    .search-box {
        text-align: center;
        margin-bottom: 20px;
    }

    input[type=text] {
        padding: 8px;
        border-radius: 6px;
        border: none;
        width: 250px;
    }

    button {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        background: #00c6ff;
        color: #000;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #0072ff;
        color: #fff;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        border-radius: 8px;
        overflow: hidden;
        margin: 0 auto;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    th {
        background: rgba(255, 255, 255, 0.4);
        font-weight: bold;
    }

    /* Black elegant text for titles/authors */
    td:nth-child(2),
    td:nth-child(3) {
        color: #000;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Stock highlighting */
    .low-stock {
        background: rgba(255, 193, 7, 0.15);
        color: #b36b00;
        font-weight: bold;
    }

    .high-stock {
        background: rgba(0, 255, 0, 0.15);
        color: #006400;
        font-weight: bold;
    }

    /* Buttons */
    .edit-btn,
    .delete-btn {
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .edit-btn {
        background: #007bff;
    }

    .edit-btn:hover {
        background: #0056b3;
    }

    .delete-btn {
        background: #d9534f;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    /* Links */
    .links {
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }

    .links a {
        margin: 0 10px;
        text-decoration: none;
        color: #003366;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h2>📚 Book Catalog</h2>

        <!-- Search bar -->
        <form method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search by title or author" value="<?= $search ?>">
            <button type="submit">🔍 Search</button>
        </form>

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
            <?php 
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){ 
                    $class = "";
                    if(!empty($row['stock']) && $row['stock'] < 10) $class = "low-stock";
                    if(!empty($row['stock']) && $row['stock'] > 50) $class = "high-stock";
            ?>
            <tr class="<?= $class ?>">
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['genre'] ?: '—' ?></td>
                <td>$<?= number_format($row['price'],2) ?></td>
                <td><?= $row['stock'] ?: '—' ?></td>
                <td><?= $row['rating'] ?: '—' ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['id'] ?>" class="edit-btn">✏️ Edit</a>
                    <a href="delete_book.php?id=<?= $row['id'] ?>" class="delete-btn">🗑 Delete</a>
                </td>
            </tr>
            <?php } } else { ?>
            <tr>
                <td colspan="8">No books found</td>
            </tr>
            <?php } ?>
        </table>

        <div class="links">
            <a href="add_book.php">➕ Add New Book</a>
            <a href="dashboard.php">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>

</html>