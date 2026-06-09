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
            $mail->Username = getenv("GMAIL_USER");     // stored in .env
            $mail->Password = getenv("GMAIL_PASS");     // stored in .env
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom(getenv("GMAIL_USER"), 'PageTurn');
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

        // 🔒 Secrets now loaded from environment
        $account_sid   = getenv("TWILIO_ACCOUNT_SID");
        $auth_token    = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        try {
            $client = new Client($account_sid, $auth_token);

            $client->messages->create(
                $phone, // recipient entered by user
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