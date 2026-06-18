<?php
include("db_connect.php"); // your database connection file

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    // Hash the password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $sql = "INSERT INTO users (username, email, password, role, phone) 
            VALUES ('$username', '$email', '$hashedPassword', 'user', '$phone')";

    if(mysqli_query($conn, $sql)){
        echo "<p style='color:green;'> Registration successful! You can now log in.</p>";
    } else {
        echo "<p style='color:red;'> Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register - PageTurn</title>
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

    .register-box {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #fff;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: none;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background: #00c6ff;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #0072ff;
        color: #fff;
    }
    </style>
</head>

<body>
    <div class="register-box">
        <h2> Register</h2>
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" placeholder="Phone (optional)">
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>