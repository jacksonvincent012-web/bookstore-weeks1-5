<?php
session_start();
include("db_connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];

    $stmt = $conn->prepare("INSERT INTO books (title, author) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $author);
    $stmt->execute();

    echo "<p style='color:lightgreen;'>✅ Book added successfully!</p>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #1e1e1e;
        color: #fff;
        font-family: Arial, sans-serif;
        height: 100vh;
        display: flex;
    }

    .sidebar {
        list-style-type: none;
        padding: 0;
        margin: 0;
        width: 300px;
        background-color: #121212;
        height: 100vh;
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
        padding: 40px;
    }

    h2 {
        font-size: 28px;
    }

    input,
    button {
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        font-size: 16px;
    }

    button {
        background: #00c6ff;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 0 10px #00c6ff;
    }

    button:hover {
        background: #0072ff;
        box-shadow: 0 0 15px #0072ff;
    }
    </style>
</head>

<body>
    <ul class="sidebar">
        <li><a href="dashboard.php">📚 Dashboard</a></li>
        <li><a href="improved_books.php">📖 Books Catalog</a></li>
        <li><a href="search_books.php">🔍 Search Books</a></li>
        <li><a href="logout.php">📕 Logout</a></li>
    </ul>
    <div class="content">
        <h2>➕ Add New Book</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required><br>
            <input type="text" name="author" placeholder="Author Name" required><br>
            <button type="submit">Add Book</button>
        </form>
    </div>
</body>

</html>