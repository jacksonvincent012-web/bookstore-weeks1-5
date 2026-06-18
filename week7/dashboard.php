<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$totalBooks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM books"))['count'];
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(price * stock), 0) AS revenue FROM books"))['revenue'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS low FROM books WHERE stock < 5"))['low'];

$topBooks = mysqli_query($conn, "SELECT title, rating, author FROM books ORDER BY rating DESC LIMIT 5");
$recentOrders = mysqli_query($conn, "SELECT o.id, u.username, o.total_amount, o.status FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC LIMIT 5");
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

    .section {
        margin-top: 40px;
    }

    .section h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    th, td {
        padding: 14px;
        text-align: left;
        color: #003366;
    }

    th {
        background: rgba(255, 255, 255, 0.4);
        font-weight: bold;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.2);
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="improved_books.php">Books Catalog</a>
        <a href="add_book.php">Add Book</a>
        <a href="search_books.php">Search Books</a>
        <a href="orders.php">Orders</a>
        <a href="ratings.php">Ratings</a>
        <a href="reports.php">Reports</a>
        <a href="users.php">User Management</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h1>Dashboard Overview</h1>

        <div class="stats">
            <div class="stat-card"><?= $totalBooks ?><br>Total Books</div>
            <div class="stat-card">$<?= number_format($totalRevenue, 2) ?><br>Total Revenue</div>
            <div class="stat-card"><?= $totalUsers ?><br>Active Users</div>
            <div class="stat-card"><?= $lowStock ?><br>Low Stock Items</div>
        </div>

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

        <div class="section">
            <h2>Top Rated Books</h2>
            <table>
                <tr><th>Title</th><th>Author</th><th>Rating</th></tr>
                <?php while($b = mysqli_fetch_assoc($topBooks)){ ?>
                <tr>
                    <td><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><?= $b['rating'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="section">
            <h2>Recent Orders</h2>
            <table>
                <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th></tr>
                <?php while($o = mysqli_fetch_assoc($recentOrders)){ ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['username']) ?></td>
                    <td>$<?= number_format($o['total_amount'], 2) ?></td>
                    <td><?= $o['status'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [32000, 35000, 37000, 40000, 45000, <?= $totalRevenue ?>],
                borderColor: '#0072ff',
                backgroundColor: 'rgba(0,114,255,0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: [
                <?php
                $genreLabels = [];
                $genreCounts = [];
                $genres = mysqli_query($conn, "SELECT genre, COUNT(*) AS count FROM books GROUP BY genre");
                while($g = mysqli_fetch_assoc($genres)){
                    $genreLabels[] = "'" . $g['genre'] . "'";
                    $genreCounts[] = $g['count'];
                }
                echo implode(",", $genreLabels);
                ?>
            ],
            datasets: [{
                label: 'Books',
                data: [<?= implode(",", $genreCounts) ?>],
                backgroundColor: ['#0072ff', '#00c6ff', '#ffcc00', '#ff4d4d', '#00ff99', '#9933ff']
            }]
        }
    });
    </script>
</body>

</html>
