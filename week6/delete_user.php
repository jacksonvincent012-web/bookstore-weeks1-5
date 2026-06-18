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

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user){
    die("User not found.");
}

if(isset($_POST['confirm'])){
    $delete = $conn->prepare("DELETE FROM users WHERE id=?");
    $delete->bind_param("i", $id);
    if($delete->execute()){
        header("Location: users.php?deleted=1");
        exit();
    } else {
        $error = "Error deleting user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Delete User – PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #003366;
        margin: 0;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 420px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    button {
        padding: 12px 20px;
        background: #d9534f;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        margin: 5px;
    }

    button:hover {
        background: #c9302c;
    }

    a.cancel {
        display: inline-block;
        padding: 12px 20px;
        background: #6c757d;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        margin: 5px;
    }

    a.cancel:hover {
        background: #5a6268;
    }

    .error {
        color: #ff4d4d;
        margin-top: 10px;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>Delete User</h2>
        <p>Are you sure you want to delete <strong><?= htmlspecialchars($user['username']) ?></strong>?</p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <form method="POST">
            <button type="submit" name="confirm">Yes, Delete</button>
            <a href="users.php" class="cancel">Cancel</a>
        </form>
        <?php if(isset($error)) echo "<p style='color:#ff4d4d;margin-top:10px;font-weight:bold;'>$error</p>"; ?>
    </div>
</body>

</html>
