<?php
session_start();
include("db_connect.php");

// Only allow admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo "<p style='color:red;'>❌ Access denied. Admins only.</p>";
    exit();
}

// Stats
$totalBooks = $conn->query("SELECT COUNT(*) AS count FROM books")->fetch_assoc()['count'];
$totalAuthors = $conn->query("SELECT COUNT(DISTINCT author) AS count FROM books")->fetch_assoc()['count'];
$recentBooks = $conn->query("SELECT title, author FROM books ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        background: #1e1e1e;
        color: #fff;
        font-family: Arial;
        height: 100vh;
        display: flex;
    }

    .sidebar {
        width: 300px;
        background: #121212;
        height: 100vh;
        box-shadow: 0 0 20px #0d6efd;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar li a {
        display: block;
        color: #fff;
        padding: 20px;
        font-size: 20px;
        text-decoration: none;
        border-bottom: 1px solid #333;
        transition: 0.3s;
    }

    .sidebar li a:hover {
        background: #0d6efd;
        box-shadow: 0 0 15px #0d6efd;
    }

    .content {
        flex: 1;
        padding: 40px;
    }

    h2 {
        font-size: 28px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #555;
        padding: 10px;
        text-align: left;
    }
    </style>
</head>

<body>
    <ul class="sidebar">
        <li><a href="dashboard.php">📚 Dashboard</a></li>
        <li><a href="improved_books.php">📖 Books Catalog</a></li>
        <li><a href="add_book.php">➕ Add Book</a></li>
        <li><a href="search_books.php">🔍 Search Books</a></li>
        <li><a href="logout.php">📕 Logout</a></li>
    </ul>
    <div class="content">
        <h2>📊 Reports</h2>
        <p>Total Books: <?php echo $totalBooks; ?></p>
        <p>Total Authors: <?php echo $totalAuthors; ?></p>
        <h3>🆕 Recent Books</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
            </tr>
            <?php while($row = $recentBooks->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['author']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>