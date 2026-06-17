<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] !== 'admin'){
    header("Location: dashboard.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex; justify-content: center; align-items: center;
        min-height: 100vh; margin: 0; color: #003366;
    }
    .card {
        background: rgba(255,255,255,0.25); backdrop-filter: blur(12px);
        padding: 40px; border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2); width: 800px; text-align: center;
    }
    h2 { margin-bottom: 20px; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: rgba(255,255,255,0.4); border-radius: 8px; overflow: hidden; }
    th, td { padding: 12px; text-align: left; color: #003366; }
    th { background: rgba(255,255,255,0.6); }
    tr:nth-child(even) { background: rgba(255,255,255,0.2); }
    a.btn { display: inline-block; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    a.edit { background: #0072ff; color: #fff; margin-right: 8px; }
    a.edit:hover { background: #005fcc; }
    a.delete { background: #ff4d4d; color: #fff; }
    a.delete:hover { background: #cc0000; }
    .back { display: inline-block; margin-top: 20px; padding: 12px 20px; background: #0072ff; color: white; border-radius: 8px; text-decoration: none; font-weight: bold; }
    .back:hover { background: #005fcc; }
    </style>
</head>
<body>
    <div class="card">
        <h2>User Management</h2>
        <table>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>
            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
                    <a href="delete_user.php?id=<?= $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="dashboard.php" class="back">Back to Dashboard</a>
    </div>
</body>
</html>
