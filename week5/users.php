<?php
include("db_connect.php");
session_start();

// Block access if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Block access if not Admin
if($_SESSION['role'] !== 'admin'){
    header("Location: dashboard.php");
    exit();
}

// Fetch all users from the database
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management - Bookstore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #243b55, #141e30);
            color: #fff;
            text-align: center;
        }
        h2 {
            margin: 20px 0;
            color: #00c6ff;
            text-shadow: 0 0 10px #00c6ff;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 0 15px rgba(0,255,255,0.3);
        }
        th, td {
            padding: 12px;
            border: 1px solid #00c6ff;
        }
        th {
            background: #00c6ff;
            color: #000;
        }
        tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
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
    <h2>👥 User Management</h2>
    <table>
        <tr><th>ID</th><th>Username</th><th>Role</th></tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['role']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</body>
</html>
