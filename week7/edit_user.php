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

if(!isset($_GET['id'])){
    die("No user ID provided.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("User not found.");
}

$user = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $phone = trim($_POST['phone']);

    if(!empty($username) && !empty($email)){
        $update = $conn->prepare("UPDATE users SET username=?, email=?, role=?, phone=? WHERE id=?");
        $update->bind_param("ssssi", $username, $email, $role, $phone, $id);

        if($update->execute()){
            header("Location: users.php?updated=1");
            exit();
        } else {
            $error = "Error updating user: " . $conn->error;
        }
    } else {
        $error = "Username and email are required.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit User – PageTurn</title>
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

    input, select {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        background: rgba(255, 255, 255, 0.4);
        color: #003366;
    }

    button {
        padding: 12px 20px;
        background: #0072ff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        width: 95%;
        margin-top: 10px;
    }

    button:hover {
        background: #005fcc;
    }

    .error {
        color: #ff4d4d;
        margin-top: 10px;
        font-weight: bold;
    }

    a {
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

    a:hover {
        background: #005fcc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>Edit User</h2>
        <form method="POST" action="">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Phone">
            <select name="role">
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            </select>
            <button type="submit">Update User</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <a href="users.php">Back to Users</a>
    </div>
</body>

</html>
