<div class="sidebar">
    <h2>📚 PageTurn</h2>

    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="books.php">📖 Books Catalog</a>
    <a href="add_book.php">➕ Add Book</a>
    <a href="reports.php">📊 Reports</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<style>
.sidebar {
    width: 220px;
    background: rgba(255, 255, 255, 0.25);
    /* frosted glass */
    backdrop-filter: blur(10px);
    padding: 20px;
    box-shadow: 4px 0 12px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    gap: 15px;
    min-height: 100vh;
}

.sidebar h2 {
    text-align: center;
    color: #003366;
    margin-bottom: 20px;
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

.sidebar a.active {
    background: rgba(255, 255, 255, 0.6);
    box-shadow: 0 0 10px rgba(0, 114, 255, 0.6);
}

.sidebar a:hover {
    background: rgba(255, 255, 255, 0.6);
}
</style>