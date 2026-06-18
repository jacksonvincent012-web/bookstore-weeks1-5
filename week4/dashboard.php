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

    .stats {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 30px;
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

    .charts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .chart {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Dashboard Overview</h1>

        <!-- Stat cards -->
        <div class="stats">
            <div class="card"> 1,248 <small>Total Books</small></div>
            <div class="card"> $48,320 <small>Total Revenue</small></div>
            <div class="card"> 384 <small>Active Users</small></div>
            <div class="card"> 67 <small>Orders Today</small></div>
        </div>

        <!-- Charts -->
        <div class="charts">
            <div class="chart">
                <h2> Revenue Overview</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart">
                <h2> Books by Genre</h2>
                <canvas id="genreChart"></canvas>
            </div>
        </div>
    </div>

    <script>
    // Revenue Overview Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [32000, 35000, 37000, 40000, 45000, 48320],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Books by Genre Chart
    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: ['Technology', 'Fiction', 'Self-Help', 'Business', 'Science', 'History'],
            datasets: [{
                label: 'Books',
                data: [320, 250, 180, 220, 150, 120],
                backgroundColor: ['#007bff', '#ff9800', '#4caf50', '#9c27b0', '#00bcd4', '#795548']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    </script>
</body>

</html>