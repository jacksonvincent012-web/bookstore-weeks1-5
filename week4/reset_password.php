<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");
session_start();

// Load PHPMailer + Twilio via Composer autoload
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['email'])){
        // ✅ Email reset flow
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();

        $resetLink = "http://localhost/week4/new_password.php?token=" . $token;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yourgmail@gmail.com'; // replace
            $mail->Password = 'your_app_password';   // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('yourgmail@gmail.com', 'PageTurn');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset';
            $mail->Body = "Click here to reset your password: $resetLink";

            $mail->send();
            $success = "✅ Reset link sent to your email!";
        } catch (Exception $e) {
            $error = "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
    elseif(!empty($_POST['phone'])){
        // ✅ Phone OTP flow
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);

        $_SESSION['otp'] = $otp;
        $_SESSION['phone'] = $phone;

        $account_sid = "AC05bca6dc950b798f46bba75ed9bdf821";
        $auth_token  = "824c6744cc0d177bd399fa12fb26eaed";
        $twilio_number = "+254110869425"; // Twilio sender

        try {
            $client = new Client($account_sid, $auth_token);

            // ✅ Send OTP to your Safaricom line
            $client->messages->create(
                "+254708208135", // recipient (your line)
                [
                    'from' => $twilio_number,
                    'body' => "Your PageTurn OTP code is: $otp"
                ]
            );
            $success = "📱 OTP sent to your phone!";
        } catch (Exception $e) {
            $error = "❌ OTP could not be sent. Error: {$e->getMessage()}";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password - PageTurn</title>
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

    .success {
        color: #28a745;
        margin-top: 10px;
        font-weight: bold;
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
        <h2>🔑 Reset Password</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email"><br>
            <button type="submit">Send Reset Link</button>
        </form>
        <hr style="margin:20px 0; border:0; border-top:1px solid #ccc;">
        <form method="POST" action="">
            <input type="text" name="phone" placeholder="Enter your phone number"><br>
            <button type="submit">Send OTP</button>
        </form>
        <?php 
        if(isset($success)) echo "<p class='success'>$success</p>"; 
        if(isset($error)) echo "<p class='error'>$error</p>"; 
        ?>
        <div class="links">
            <a href="login.php">⬅ Back to Login</a>
        </div>
    </div>
</body>

</html>