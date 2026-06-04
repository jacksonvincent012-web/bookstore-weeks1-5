<?php
session_start();

// Redirect if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Bookstore</title>
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
        .dashboard-box {
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
        a {
            display: block;
            margin: 10px 0;
            padding: 12px;
            background: #00c6ff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
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
    <div class="dashboard-box">
        <h2>📊 Welcome, <?php echo $username; ?>!</h2>
        <p>Role: <?php echo ucfirst($role); ?></p>

        <!-- Links for all users -->
        <a href="books.php">📚 Manage Books</a>
        <a href="reports.php">📑 View Reports</a>

        <!-- Extra links only for Admins -->
        <?php if($role === 'admin'){ ?>
            <a href="users.php">👥 Manage Users</a>
        <?php } ?>

        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
