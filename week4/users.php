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

// Search functionality
$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM users";
}
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Management - PageTurn</title>
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
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #00c6ff;
    }

    th {
        background: #00c6ff;
        color: #000;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.05);
    }

    .badge-admin {
        background: #007bff;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .badge-user {
        background: #28a745;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .edit-btn,
    .delete-btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .edit-btn {
        background: #ffc107;
        color: #000;
    }

    .edit-btn:hover {
        background: #e0a800;
    }

    .delete-btn {
        background: #d9534f;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c9302c;
    }

    .search-box {
        margin: 20px;
    }

    input[type=text] {
        padding: 8px;
        border-radius: 6px;
        border: none;
        width: 250px;
    }

    button {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        background: #00c6ff;
        color: #000;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #0072ff;
        color: #fff;
    }
    </style>
</head>

<body>
    <h2> User Management</h2>

    <!-- Search bar -->
    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search by username" value="<?= $search ?>">
        <button type="submit"> Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td>
                <?php if($row['role'] === 'admin'){ ?>
                <span class="badge-admin">Admin</span>
                <?php } else { ?>
                <span class="badge-user">User</span>
                <?php } ?>
            </td>
            <td>
                <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a>
                <a href="delete_user.php?id=<?= $row['id'] ?>" class="delete-btn"> Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="dashboard.php"> Back to Dashboard</a>
</body>

</html>