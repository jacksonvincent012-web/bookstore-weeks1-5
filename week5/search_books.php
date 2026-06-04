<?php
session_start();
include("db_connect.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search Books</title>
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
        width: 300px;
        background-color: #121212;
        height: 100vh;
        box-shadow: 0 0 20px #0d6efd;
        list-style-type: none;
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
        background-color: #0d6efd;
        box-shadow: 0 0 15px #0d6efd;
    }

    .content {
        flex: 1;
        padding: 40px;
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
        <li><a href="logout.php">📕 Logout</a></li>
    </ul>
    <div class="content">
        <h2>🔍 Search Books</h2>
        <form method="GET">
            <input type="text" name="query" placeholder="Enter title or author">
            <button type="submit">Search</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
            </tr>
            <?php
            if(isset($_GET['query'])){
                $q = "%".$_GET['query']."%";
                $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
                $stmt->bind_param("ss", $q, $q);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['author']}</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</body>

</html>