<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("No book ID provided.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Book not found.");
}

$book = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title  = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre  = trim($_POST['genre']);
    $price  = trim($_POST['price']);
    $stock  = trim($_POST['stock']);
    $rating = trim($_POST['rating']);

    $errors = [];
    if(empty($title)) $errors[] = "Title is required.";
    if(empty($author)) $errors[] = "Author is required.";
    if(empty($genre)) $errors[] = "Genre is required.";
    if($price === "" || !is_numeric($price) || $price < 0) $errors[] = "Valid price is required.";
    if($stock === "" || !is_numeric($stock) || $stock < 0) $errors[] = "Valid stock quantity is required.";
    if($rating === "" || !is_numeric($rating) || $rating < 0 || $rating > 5) $errors[] = "Rating must be between 0 and 5.";

    if(empty($errors)){
        $update = $conn->prepare("UPDATE books SET title=?, author=?, genre=?, price=?, stock=?, rating=? WHERE id=?");
        $update->bind_param("sssdisi", $title, $author, $genre, $price, $stock, $rating, $id);
        if($update->execute()){
            header("Location: improved_books.php?updated=1");
            exit();
        } else {
            $error = "Error updating book: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book - PageTurn</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .form-card {
        width: 50%;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(8px);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin: auto;
    }
    .form-card label { font-weight: bold; margin-top: 10px; display: block; }
    .form-card input, .form-card select {
        width: 100%; padding: 8px; margin-top: 5px;
        border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;
    }
    .form-card button {
        margin-top: 15px; padding: 10px 18px;
        background: #007bff; color: white;
        border: none; border-radius: 6px; cursor: pointer;
    }
    .form-card button:hover { background: #0056b3; }
    .error { color: #ff4d4d; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1 class="page-title">Edit Book</h1>
        <form method="POST" class="form-card">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

            <label>Author</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

            <label>Genre</label>
            <select name="genre" required>
                <option value="<?= htmlspecialchars($book['genre']) ?>" selected><?= htmlspecialchars($book['genre']) ?></option>
                <option value="Business">Business</option>
                <option value="Productivity">Productivity</option>
                <option value="Fiction">Fiction</option>
                <option value="Memoir">Memoir</option>
                <option value="Science">Science</option>
            </select>

            <label>Price ($)</label>
            <input type="number" step="0.01" min="0" name="price" value="<?= $book['price'] ?>" required>

            <label>Stock</label>
            <input type="number" min="0" name="stock" value="<?= $book['stock'] ?>" required>

            <label>Rating (0-5)</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" value="<?= $book['rating'] ?>" required>

            <button type="submit">Update Book</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if(!empty($errors)) foreach($errors as $e) echo "<p class='error'>$e</p>"; ?>
        <br><a href="improved_books.php">Back to Books</a>
    </div>
</body>
</html>
