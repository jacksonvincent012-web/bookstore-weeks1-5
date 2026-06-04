<?php
include("db_connect.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Bookstore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #141e30, #243b55);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .login-box {
            background: rgba(0,0,0,0.7);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(0,255,255,0.4);
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
            color: #00c6ff;
            text-shadow: 0 0 10px #00c6ff;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            outline: none;
            background: #1f1f1f;
            color: #fff;
            box-shadow: inset 0 0 5px #00c6ff;
        }
        button {
            background: #00c6ff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 0 10px #00c6ff;
            transition: 0.3s;
        }
        button:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
        .error {
            color: #ff4b2b;
            margin-top: 15px;
            font-weight: bold;
            text-shadow: 0 0 5px #ff4b2b;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Bookstore Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Enter Username" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
