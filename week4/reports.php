<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Fetch data
$totalBooks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM books"))['count'];
$mostAuthor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT author, COUNT(*) AS count FROM books GROUP BY author ORDER BY count DESC LIMIT 1"));
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price * stock) AS revenue FROM books"))['revenue'];
$topBook = mysqli_fetch_assoc(mysqli_query($conn, "SELECT title, rating FROM books ORDER BY rating DESC LIMIT 1"));
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS low FROM books WHERE stock < 5"))['low'];
$genres = mysqli_query($conn, "SELECT genre, COUNT(*) AS count FROM books GROUP BY genre");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reports - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #003366;
        margin: 0;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 700px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    .metric {
        margin: 10px 0;
        font-size: 18px;
    }

    .genre {
        text-align: left;
        margin-top: 20px;
    }

    a.back {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 20px;
        background: #0072ff;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a.back:hover {
        background: #005fcc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>📊 Reports</h2>
        <div class="metric">Total Books: <?= $totalBooks ?></div>
        <div class="metric">Most Frequent Author: <?= htmlspecialchars($mostAuthor['author']) ?>
            (<?= $mostAuthor['count'] ?> books)</div>
        <div class="metric">Total Revenue: $<?= number_format($totalRevenue, 2) ?></div>
        <div class="metric">Top Rated Book: <?= htmlspecialchars($topBook['title']) ?> (⭐ <?= $topBook['rating'] ?>)
        </div>
        <div class="metric">Low Stock Alerts: <?= $lowStock ?> books</div>

        <div class="genre">
            <h3>📚 Genre Breakdown</h3>
            <?php while($g = mysqli_fetch_assoc($genres)){ ?>
            <div><?= htmlspecialchars($g['genre']) ?>: <?= $g['count'] ?> books</div>
            <?php } ?>
        </div>

        <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>
    </div>
</body>

</html>