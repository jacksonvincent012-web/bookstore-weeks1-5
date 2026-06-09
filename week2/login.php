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
    <title>Login – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="login-container">
        <h1>PageTurn</h1>
        <p>Welcome back</p>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Sign In</button>
        </form>

        <?php 
        if(isset($error)) {
            echo "<p class='error' style='color:red; margin-top:10px;'>$error</p>";
        }
    ?>

        <p class="demo">admin / admin123</p>
    </div>

</body>

</html>