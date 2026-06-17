<?php
session_start();
include("db_connect.php"); // connect to your database

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query user
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);

        // Direct check against plain password (e.g. 123456)
        if($password === $row['password']){
            $_SESSION['user'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = " Invalid password!";
        }
    } else {
        $error = " User not found!";
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
    }

    .login-box {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        width: 300px;
    }

    h2 {
        margin-bottom: 20px;
        color: #fff;
        text-align: center;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
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
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2> Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="error"><?php if(isset($error)) echo $error; ?></div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>