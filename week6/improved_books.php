<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM books");
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Books Catalog - PageTurn</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .search-box { margin: 20px 0; display: flex; gap: 10px; }
    .search-box input { flex: 1; padding: 10px; border-radius: 6px; border: none; }
    .search-box button { padding: 10px 18px; }
    .success-msg { color: #28a745; font-weight: bold; }
    .info-msg { color: #0072ff; font-weight: bold; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <?php if(isset($_GET['updated'])) echo "<p class='info-msg'>Book updated successfully!</p>"; ?>

        <h1 class="page-title">Books Catalog</h1>

        <form method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search by title or author" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <table>
            <tr>
                <th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Price</th>
                <th>Stock</th><th>Rating</th><th>Actions</th>
            </tr>
            <?php if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $class = "";
                    if($row['stock'] < 10) $class = "low-stock";
                    if($row['stock'] > 50) $class = "high-stock";
            ?>
            <tr class="<?= $class ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= $row['genre'] ?></td>
                <td>$<?= number_format($row['price'],2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td><?= $row['rating'] ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                    <a href="delete_book.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                </td>
            </tr>
            <?php } } else { ?>
            <tr><td colspan="8">No books found</td></tr>
            <?php } ?>
        </table>

        <div style="margin-top:20px; display:flex; gap:10px;">
            <a href="add_book.php" class="btn">Add New Book</a>
            <a href="dashboard.php" class="btn">Dashboard</a>
        </div>
    </div>
</body>
</html>
