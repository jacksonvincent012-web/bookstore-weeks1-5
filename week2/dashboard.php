<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard – PageTurn</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        margin: 0;
        padding: 0;
        color: #003366;
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 220px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        padding: 20px;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-height: 100vh;
    }

    .sidebar a {
        display: block;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        color: #003366;
        background: rgba(255, 255, 255, 0.4);
        transition: 0.3s;
        text-align: center;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.6);
    }

    /* Main content */
    .main {
        flex: 1;
        padding: 40px;
    }

    h1.page-title {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .cards {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .card {
        flex: 1;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        font-weight: bold;
    }

    .card small {
        display: block;
        margin-top: 8px;
        font-weight: normal;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">📊 Dashboard</h1>

        <!-- Stat cards -->
        <div class="cards">
            <div class="card">📚 1,248 <small>Total Books</small></div>
            <div class="card">💰 $48,320 <small>Total Revenue</small></div>
            <div class="card">👥 384 <small>Active Users</small></div>
            <div class="card">🛒 67 <small>Orders Today</small></div>
        </div>
    </div>
</body>

</html>