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
    <title>Improved Book Catalog</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #141e30, #243b55);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .catalog-box {
            background: rgba(0,0,0,0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0,255,255,0.4);
            width: 750px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #00c6ff;
            text-shadow: 0 0 10px #00c6ff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
        }
        th {
            background: #00c6ff;
            color: #fff;
            text-shadow: 0 0 5px #00c6ff;
        }
        tr:hover {
            background: rgba(0, 198, 255, 0.2);
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
            background: #ffcc00;
            color: #000;
            box-shadow: 0 0 10px #ffcc00;
        }
        a.edit:hover {
            background: #ff9900;
            box-shadow: 0 0 20px #ff9900;
        }
        a.delete {
            background: #ff416c;
            color: #fff;
            box-shadow: 0 0 10px #ff416c;
        }
        a.delete:hover {
            background: #ff4b2b;
            box-shadow: 0 0 20px #ff4b2b;
        }
        a.add {
            background: #00c6ff;
            color: #fff;
            box-shadow: 0 0 10px #00c6ff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }
        a.add:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
    </style>
</head>
<body>
    <div class="catalog-box">
        <h2>📚 Improved Book Catalog</h2>
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
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['author']."</td>";
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
        <a href="add_book.php" class="add">➕ Add New Book</a><br><br>
        <a href="dashboard.php" class="add">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
