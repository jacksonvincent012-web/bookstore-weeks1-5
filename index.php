<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageTurn Bookstore - Home</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .card {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 700px;
            width: 90%;
        }
        h1 { margin-bottom: 0.5rem; font-size: 2rem; }
        p { margin-bottom: 2rem; opacity: 0.9; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.75rem;
        }
        .grid a {
            background: rgba(255,255,255,0.25);
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .grid a:hover { background: rgba(255,255,255,0.5); transform: translateY(-2px); }
        .admin-info { margin-top: 2rem; font-size: 0.85rem; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="card">
        <h1>PageTurn Bookstore</h1>
        <p>PHP + MySQL Management System — Weeks 1 to 8</p>
        <div class="grid">
            <a href="week1/">Week 1</a>
            <a href="week2/">Week 2</a>
            <a href="week3/">Week 3</a>
            <a href="week4/">Week 4</a>
            <a href="week5/">Week 5</a>
            <a href="week6/">Week 6</a>
            <a href="week7/">Week 7</a>
            <a href="week8/profile.html">Week 8</a>
        </div>
        <div class="admin-info">Admin: admin / P@geTurn2024</div>
    </div>
</body>
</html>
