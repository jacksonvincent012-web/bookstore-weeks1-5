<?php
include("db_connect.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password === $confirm_password){
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);

        //  Email reset flow
        if(!empty($_GET['token'])){
            $token = $_GET['token'];
            $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token=? AND expires_at > NOW()");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if($row = $result->fetch_assoc()){
                $email = $row['email'];
                $stmt2 = $conn->prepare("UPDATE users SET password=? WHERE email=?");
                $stmt2->bind_param("ss", $hashed, $email);
                $stmt2->execute();
                header("Location: login.php?reset=success");
                exit();
            } else {
                $error = " Invalid or expired token.";
            }
        }
        //  Phone OTP flow
        elseif(!empty($_POST['otp'])){
            $otp = $_POST['otp'];
            if(isset($_SESSION['otp']) && $otp == $_SESSION['otp']){
                $phone = $_SESSION['phone'];
                $stmt3 = $conn->prepare("UPDATE users SET password=? WHERE phone=?");
                $stmt3->bind_param("ss", $hashed, $phone);
                $stmt3->execute();
                unset($_SESSION['otp']);
                header("Location: login.php?reset=success");
                exit();
            } else {
                $error = " Invalid OTP.";
            }
        }
    } else {
        $error = " Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Set New Password - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #003366;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 380px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #003366;
        font-weight: bold;
    }

    input {
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
    }

    button:hover {
        background: #005fcc;
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
        <h2> Set New Password</h2>
        <form method="POST" action="">
            <input type="password" name="new_password" placeholder="Enter new password"><br>
            <input type="password" name="confirm_password" placeholder="Confirm new password"><br>
            <?php if(!empty($_GET['token'])): ?>
            <button type="submit">Update Password</button>
            <?php else: ?>
            <input type="text" name="otp" placeholder="Enter OTP"><br>
            <button type="submit">Update Password</button>
            <?php endif; ?>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <div class="links">
            <a href="login.php"> Back to Login</a>
        </div>
    </div>
</body>

</html>