<?php
include("db_connect.php");
session_start();

// Block access if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Query total books
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books"))['total'];

// Query most frequent author
$author = mysqli_fetch_assoc(mysqli_query($conn, "SELECT author, COUNT(*) AS count 
    FROM books GROUP BY author ORDER BY count DESC LIMIT 1"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - Bookstore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #141e30, #243b55);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .report-box {
            background: rgba(0,0,0,0.7);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(0,255,255,0.4);
            width: 400px;
        }
        h2 {
            margin-bottom: 20px;
            color: #00c6ff;
            text-shadow: 0 0 10px #00c6ff;
        }
        p {
            font-size: 18px;
            margin: 15px 0;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #00c6ff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 0 10px #00c6ff;
            transition: 0.3s;
        }
        a:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
    </style>
</head>
<body>
    <div class="report-box">
        <h2>📊 Reports</h2>
        <p>Total Books: <?php echo $total_books; ?></p>
        <p>Most Frequent Author: <?php echo $author['author']; ?> (<?php echo $author['count']; ?> books)</p>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
