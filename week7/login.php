<?php
session_start();
include("db_connect.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        $error = "Please enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['user'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        color: #003366;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        width: 300px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background: #00c6ff;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #0072ff;
        color: #fff;
    }

    .error {
        color: #ff4d4d;
        font-size: 0.9em;
        margin-top: 5px;
    }

    a {
        color: #0072ff;
        display: block;
        margin-top: 12px;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Create an account</a>
    </div>
</body>

</html>
