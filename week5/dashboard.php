<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - PageTurn</title>
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
        backdrop-filter: blur(12px);
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

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .stats {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 200px;
        text-align: center;
        font-weight: bold;
    }

    .charts {
        display: flex;
        gap: 40px;
        justify-content: center;
        margin-top: 40px;
    }

    .chart {
        flex: 1;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    canvas {
        width: 100% !important;
        height: 300px !important;
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"> Dashboard</a>
        <a href="improved_books.php"> Books Catalog</a>
        <a href="add_book.php"> Add Book</a>
        <a href="search_books.php"> Search Books</a>
        <a href="reports.php"> Reports</a>
        <a href="users.php"> User Management</a>
        <a href="logout.php"> Logout</a>
    </div>

    <!-- Main content -->
    <div class="main">
        <h1> Dashboard Overview</h1>

        <!-- Stat cards -->
        <div class="stats">
            <div class="stat-card">1,248<br>Total Books</div>
            <div class="stat-card">$48,320<br>Total Revenue</div>
            <div class="stat-card">384<br>Active Users</div>
            <div class="stat-card">67<br>Orders Today</div>
        </div>

        <!-- Charts -->
        <div class="charts">
            <div class="chart">
                <h3>Revenue Overview</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart">
                <h3>Books by Genre</h3>
                <canvas id="genreChart"></canvas>
            </div>
        </div>
    </div>

    <script>
    // Revenue line chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [32000, 35000, 37000, 40000, 45000, 48320],
                borderColor: '#0072ff',
                backgroundColor: 'rgba(0,114,255,0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Books by Genre bar chart
    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: ['Technology', 'Fiction', 'Self-Help', 'Business', 'Science', 'History'],
            datasets: [{
                label: 'Books',
                data: [300, 250, 180, 220, 150, 98],
                backgroundColor: ['#0072ff', '#00c6ff', '#ffcc00', '#ff4d4d', '#00ff99', '#9933ff']
            }]
        }
    });
    </script>
</body>

</html>