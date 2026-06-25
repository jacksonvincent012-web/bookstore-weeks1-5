<?php
// sidebar.php — reusable navigation
?>
<div class="sidebar">
    <a href="dashboard.php"> Dashboard</a>
    <a href="improved_books.php"> Books Catalog</a>
    <a href="add_book.php"> Add Book</a>
    <a href="search_books.php"> Search Books</a>
    <a href="reports.php"> Reports</a>
    <a href="users.php"> User Management</a>
    <a href="logout.php"> Logout</a>
    <?php include '../week_nav.php'; ?>
</div>

<style>
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
</style>