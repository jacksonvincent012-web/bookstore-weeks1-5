<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

function checkRole($requiredRole){
    if($_SESSION['role'] !== $requiredRole){
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Access Denied - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex; justify-content: center; align-items: center;
        height: 100vh; margin: 0; color: #003366;
    }
    .card {
        background: rgba(255,255,255,0.25); backdrop-filter: blur(12px);
        padding: 40px; border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2); width: 420px; text-align: center;
    }
    h2 { margin-bottom: 20px; font-weight: bold; }
    a { display: inline-block; margin-top: 20px; padding: 12px 20px; background: #0072ff; color: white; border-radius: 8px; text-decoration: none; font-weight: bold; }
    a:hover { background: #005fcc; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Access Denied</h2>
        <p>You must be an <strong><?php echo ucfirst($requiredRole); ?></strong> to view this page.</p>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
        exit();
    }
}
?>
