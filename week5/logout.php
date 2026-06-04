<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Logout</title>
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
    }

    h2 {
        font-size: 28px;
    }
    </style>
</head>

<body>
    <h2>📕 You have been logged out</h2>
    <a href="login.php" style="color:#00c6ff; font-size:20px;">🔑 Login Again</a>
</body>

</html>