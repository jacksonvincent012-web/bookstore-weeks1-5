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
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM books WHERE stock < 5"))['count'];
$topBooks = mysqli_query($conn, "SELECT title, rating FROM books ORDER BY rating DESC LIMIT 5");
$recentOrders = mysqli_query($conn, "SELECT o.id, o.order_date, o.total_amount, o.status, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        margin: 0; padding: 0; color: #003366; display: flex;
    }
    .main { flex: 1; padding: 40px; margin-left: 260px; }
    h1 { text-align: center; margin-bottom: 30px; font-weight: bold; }
    .stats { display: flex; gap: 20px; justify-content: center; margin-bottom: 40px; flex-wrap: wrap; }
    .stat-card {
        background: rgba(255,255,255,0.25); backdrop-filter: blur(12px);
        padding: 20px; border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        width: 180px; text-align: center; font-weight: bold;
    }
    .stat-card .number { font-size: 28px; color: #fff; }
    .stat-card .label { font-size: 14px; color: #003366; margin-top: 5px; }
    .charts { display: flex; gap: 40px; justify-content: center; margin-top: 40px; flex-wrap: wrap; }
    .chart { flex: 1; min-width: 300px; background: rgba(255,255,255,0.25); backdrop-filter: blur(12px); padding: 20px; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); text-align: center; }
    canvas { width: 100% !important; height: 300px !important; }
    .section { background: rgba(255,255,255,0.25); backdrop-filter: blur(12px); padding: 20px; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); margin-top: 20px; }
    .section table { width: 100%; border-collapse: collapse; }
    .section th, .section td { padding: 10px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.3); }
    .section th { background: rgba(255,255,255,0.3); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Dashboard Overview</h1>

        <div class="stats">
            <div class="stat-card"><div class="number"><?= $totalBooks ?></div><div class="label">Total Books</div></div>
            <div class="stat-card"><div class="number">$<?= number_format($totalRevenue) ?></div><div class="label">Total Revenue</div></div>
            <div class="stat-card"><div class="number"><?= $totalUsers ?></div><div class="label">Users</div></div>
            <div class="stat-card"><div class="number"><?= $lowStock ?></div><div class="label">Low Stock Items</div></div>
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
            <h3>Top Rated Books</h3>
            <table>
                <tr><th>Title</th><th>Rating</th></tr>
                <?php while($b = $topBooks->fetch_assoc()){ ?>
                <tr><td><?= htmlspecialchars($b['title']) ?></td><td><?= $b['rating'] ?> / 5</td></tr>
                <?php } ?>
            </table>
        </div>

        <div class="section">
            <h3>Recent Orders</h3>
            <?php if($recentOrders && $recentOrders->num_rows > 0){ ?>
            <table>
                <tr><th>Order #</th><th>Customer</th><th>Date</th><th>Amount</th><th>Status</th></tr>
                <?php while($o = $recentOrders->fetch_assoc()){ ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['username']) ?></td>
                    <td><?= date("M d, Y", strtotime($o['order_date'])) ?></td>
                    <td>$<?= number_format($o['total_amount'], 2) ?></td>
                    <td><?= ucfirst($o['status']) ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <p>No orders yet.</p>
            <?php } ?>
        </div>
    </div>

    <script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun'],
            datasets: [{ label: 'Revenue ($)', data: [32000,35000,37000,40000,45000,<?= $totalRevenue ?>], borderColor: '#0072ff', backgroundColor: 'rgba(0,114,255,0.2)', fill: true, tension: 0.3 }]
        }
    });
    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: [<?php $gResult = mysqli_query($conn, "SELECT genre FROM books GROUP BY genre"); $glabels = []; while($g = $gResult->fetch_assoc()){ $glabels[] = "'" . $g['genre'] . "'"; } echo implode(',', $glabels); ?>],
            datasets: [{
                label: 'Books',
                data: [<?php $gResult2 = mysqli_query($conn, "SELECT COUNT(*) AS count FROM books GROUP BY genre"); $gcounts = []; while($g = $gResult2->fetch_assoc()){ $gcounts[] = $g['count']; } echo implode(',', $gcounts); ?>],
                backgroundColor: ['#0072ff','#00c6ff','#ffcc00','#ff4d4d','#00ff99','#9933ff']
            }]
        }
    });
    </script>
</body>
</html>
