<?php
include("db_connect.php");
session_start();

// Check if user is logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Fetch books from database
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Catalog</title>
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
            width: 600px;
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
        a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        a.back {
            background: #ffcc00;
            color: #000;
            box-shadow: 0 0 10px #ffcc00;
        }
        a.back:hover {
            background: #ff9900;
            box-shadow: 0 0 20px #ff9900;
        }
    </style>
</head>
<body>
    <div class="catalog-box">
        <h2>📚 Book Catalog</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['author']."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No books found</td></tr>";
            }
            ?>
        </table>
        <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
