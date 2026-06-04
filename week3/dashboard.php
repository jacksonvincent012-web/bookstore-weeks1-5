<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Bookstore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .dashboard-box {
            background: rgba(0,0,0,0.6);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(255,255,255,0.2);
            width: 400px;
        }
        h2 {
            margin-bottom: 10px;
            color: #ffcc00;
        }
        p {
            margin-bottom: 30px;
            font-size: 16px;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        a.view {
            background: #00c6ff;
            color: #fff;
            box-shadow: 0 0 10px #00c6ff;
        }
        a.view:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
        a.logout {
            background: #ff416c;
            color: #fff;
            box-shadow: 0 0 10px #ff416c;
        }
        a.logout:hover {
            background: #ff4b2b;
            box-shadow: 0 0 20px #ff4b2b;
        }
    </style>
</head>
<body>
    <div class="dashboard-box">
        <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
        <p>You have successfully logged in to the Bookstore system.</p>
        <!-- Updated link -->
        <a href="improved_books.php" class="view">📚 View Books</a>
        <a href="logout.php" class="logout">📕 Logout</a>
    </div>
</body>
</html>
