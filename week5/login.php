<?php
session_start();
include("db_connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        if(password_verify($password, $row['password']) || $password === $row['password']){
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ User not found!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #1e1e1e;
        color: #fff;
        font-family: Arial, sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
    }

    input,
    button {
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        font-size: 16px;
    }

    button {
        background: #00c6ff;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 0 10px #00c6ff;
    }

    button:hover {
        background: #0072ff;
        box-shadow: 0 0 15px #0072ff;
    }

    .error {
        color: red;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <h2>🔑 Login to Bookstore</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
</body>

</html>