<?php
session_start();

// Safe include for db_connect.php
if(file_exists("db_connect.php")){
    include("db_connect.php");
} else {
    echo "<p style='color:red;'>⚠️ Database connection file missing (db_connect.php)</p>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bookstore Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
    /* Fullscreen square layout */
    body {
        margin: 0;
        padding: 0;
        background-color: #1e1e1e;
        color: #fff;
        font-family: Arial, sans-serif;
        height: 100vh;
        /* full height */
        display: flex;
    }

    .sidebar {
        list-style-type: none;
        padding: 0;
        margin: 0;
        width: 300px;
        /* wider sidebar */
        background-color: #121212;
        height: 100vh;
        /* full height */
        box-shadow: 0 0 20px #0d6efd;
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
        background-color: #0d6efd;
        box-shadow: 0 0 15px #0d6efd;
    }

    .content {
        flex: 1;
        /* take remaining space */
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h2 {
        font-size: 32px;
    }
    </style>
</head>

<body>
    <ul class="sidebar">
        <li><a href="improved_books.php">📖 Books Catalog</a></li>
        <li><a href="add_book.php">➕ Add Book</a></li>
        <li><a href="search_books.php">🔍 Search Books</a></li>
        <?php 
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'){ 
        ?>
        <li><a href="reports.php">📊 Reports</a></li>
        <?php } ?>
        <li><a href="logout.php">📕 Logout</a></li>
    </ul>
    <div class="content">
        <h2>📚 Bookstore Dashboard</h2>
    </div>
</body>

</html>