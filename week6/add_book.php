<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

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
        $stmt = $conn->prepare("INSERT INTO books (title, author, genre, price, stock, rating) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdis", $title, $author, $genre, $price, $stock, $rating);
        if($stmt->execute()){
            header("Location: books.php?success=1");
            exit();
        } else {
            $error = "Error adding book: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        color: #003366;
    }
    .card {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        width: 400px;
    }
    h2 { text-align: center; margin-bottom: 20px; color: #fff; }
    label { display: block; margin-top: 12px; font-weight: bold; color: #fff; }
    input, select {
        width: 100%; padding: 10px; margin-top: 4px;
        border: none; border-radius: 6px; box-sizing: border-box;
    }
    button {
        width: 100%; padding: 12px; margin-top: 20px;
        border: none; border-radius: 6px;
        background: #0072ff; color: #fff;
        font-weight: bold; cursor: pointer;
    }
    button:hover { background: #005fcc; }
    .error { color: #ff4d4d; margin: 10px 0; font-weight: bold; text-align: center; }
    .success { color: #28a745; font-weight: bold; text-align: center; }
    a { display: block; text-align: center; margin-top: 15px; color: #fff; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Add New Book</h2>
        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" required>

            <label>Author</label>
            <input type="text" name="author" required>

            <label>Genre</label>
            <select name="genre" required>
                <option value="">Select Genre</option>
                <option value="Fiction">Fiction</option>
                <option value="Business">Business</option>
                <option value="Science">Science</option>
                <option value="Productivity">Productivity</option>
                <option value="Memoir">Memoir</option>
            </select>

            <label>Price ($)</label>
            <input type="number" step="0.01" min="0" name="price" required>

            <label>Stock</label>
            <input type="number" min="0" name="stock" required>

            <label>Rating (0-5)</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" required>

            <button type="submit">Add Book</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if(!empty($errors)) foreach($errors as $e) echo "<p class='error'>$e</p>"; ?>
        <a href="books.php">Back to Books</a>
    </div>
</body>
</html>
