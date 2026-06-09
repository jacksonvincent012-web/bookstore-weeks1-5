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
        color: #003366;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 350px;
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

    input::placeholder {
        color: #555;
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

    .success {
        color: #28a745;
        margin-top: 10px;
        font-weight: bold;
    }

    .links {
        margin-top: 15px;
    }

    .links a {
        color: #003366;
        text-decoration: none;
        font-weight: bold;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>📝 Register</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
        </form>
        <?php 
        if(isset($error)) echo "<p class='error'>$error</p>"; 
        if(isset($success)) echo "<p class='success'>$success</p>"; 
        ?>
        <div class="links">
            <a href="login.php">⬅ Back to Login</a>
        </div>
    </div>
</body>

</html>