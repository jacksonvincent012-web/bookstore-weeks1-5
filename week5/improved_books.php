<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Book Catalog - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #003366;
        margin: 0;
    }

    .catalog-card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 900px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        color: #003366;
    }

    th {
        background: rgba(255, 255, 255, 0.6);
        font-weight: bold;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.2);
    }

    a.action {
        margin: 0 5px;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a.edit {
        background: #0072ff;
        color: #fff;
    }

    a.edit:hover {
        background: #005fcc;
    }

    a.delete {
        background: #ff4d4d;
        color: #fff;
    }

    a.delete:hover {
        background: #cc0000;
    }

    a.add {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 20px;
        background: #0072ff;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a.add:hover {
        background: #005fcc;
    }
    </style>
</head>

<body>
    <div class="catalog-card">
        <h2>📚 Book Catalog</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".htmlspecialchars($row['title'])."</td>";
                    echo "<td>".htmlspecialchars($row['author'])."</td>";
                    echo "<td>
                        <a href='edit_book.php?id=".$row['id']."' class='action edit'>✏️ Edit</a>
                        <a href='delete_book.php?id=".$row['id']."' class='action delete' onclick=\"return confirm('Delete this book?');\">🗑 Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No books found</td></tr>";
            }
            ?>
        </table>
        <a href="add_book.php" class="add">➕ Add New Book</a>
        <a href="dashboard.php" class="add">⬅ Back to Dashboard</a>
    </div>
</body>

</html>