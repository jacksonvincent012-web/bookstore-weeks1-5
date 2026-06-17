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
    <title>Books - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #243b55, #141e30);
        color: #fff;
        text-align: center;
        margin: 0; padding: 20px;
    }
    h2 { margin: 20px 0; color: #00c6ff; text-shadow: 0 0 10px #00c6ff; }
    table { margin: 20px auto; border-collapse: collapse; width: 95%; box-shadow: 0 0 15px rgba(0,255,255,0.3); }
    th, td { padding: 12px; border: 1px solid #00c6ff; }
    th { background: #00c6ff; color: #000; }
    tr:nth-child(even) { background: rgba(255,255,255,0.05); }
    .low-stock { background: rgba(255,193,7,0.15); color: #b36b00; font-weight: bold; }
    .high-stock { background: rgba(0,255,0,0.15); color: #006400; font-weight: bold; }
    .edit-btn, .delete-btn { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    .edit-btn { background: #007bff; color: #fff; }
    .edit-btn:hover { background: #0056b3; }
    .delete-btn { background: #d9534f; color: #fff; }
    .delete-btn:hover { background: #c9302c; }
    .search-box { margin: 20px; }
    input[type=text] { padding: 8px; border-radius: 6px; border: none; width: 250px; }
    button { padding: 8px 14px; border: none; border-radius: 6px; background: #00c6ff; color: #000; font-weight: bold; cursor: pointer; }
    button:hover { background: #0072ff; color: #fff; }
    a.action-link { display: inline-block; margin: 10px; padding: 10px 18px; background: #00c6ff; color: #000; border-radius: 6px; text-decoration: none; font-weight: bold; }
    a.action-link:hover { background: #0072ff; color: #fff; }
    .success { color: #28a745; margin: 10px 0; }
    </style>
</head>
<body>
    <?php if(isset($_GET['success'])) echo "<p class='success'>Book added successfully!</p>"; ?>
    <?php if(isset($_GET['deleted'])) echo "<p class='success'>Book deleted successfully!</p>"; ?>

    <h2>Book Catalog</h2>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search by title or author" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Genre</th>
            <th>Price</th><th>Stock</th><th>Rating</th><th>Actions</th>
        </tr>
        <?php if($result->num_rows > 0){ while($row = $result->fetch_assoc()){
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

    <a href="add_book.php" class="action-link">Add New Book</a>
    <a href="dashboard.php" class="action-link">Back to Dashboard</a>
</body>
</html>
