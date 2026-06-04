<?php
session_start();
include("db_connect.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Books Catalog</title>
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

    a.btn {
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .edit {
        background: #00c6ff;
        color: #fff;
        box-shadow: 0 0 10px #00c6ff;
    }

    .edit:hover {
        background: #0072ff;
        box-shadow: 0 0 15px #0072ff;
    }

    .delete {
        background: #ff4d4d;
        color: #fff;
        box-shadow: 0 0 10px #ff4d4d;
    }

    .delete:hover {
        background: #cc0000;
        box-shadow: 0 0 15px #cc0000;
    }
    </style>
</head>

<body>
    <ul class="sidebar">
        <li><a href="dashboard.php">📚 Dashboard</a></li>
        <li><a href="add_book.php">➕ Add Book</a></li>
        <li><a href="search_books.php">🔍 Search Books</a></li>
        <li><a href="logout.php">📕 Logout</a></li>
    </ul>
    <div class="content">
        <h2>📘 Books Catalog</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM books");
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>
                            <a class='btn edit' href='edit_book.php?id={$row['id']}'>✏️ Edit</a>
                            <a class='btn delete' href='delete_book.php?id={$row['id']}'>🗑 Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>