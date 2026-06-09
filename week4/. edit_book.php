<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("❌ No book ID provided.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);

if(!$result || mysqli_num_rows($result) == 0){
    die("❌ Book not found.");
}

$book = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $genre  = $_POST['genre'];
    $price  = $_POST['price'];
    $stock  = $_POST['stock'];
    $rating = $_POST['rating'];

    $update = "UPDATE books 
               SET title='$title', author='$author', genre='$genre',
                   price='$price', stock='$stock', rating='$rating'
               WHERE id=$id";

    if(mysqli_query($conn, $update)){
        header("Location: improved_books.php?updated=1");
        exit();
    } else {
        $error = "❌ Error updating book: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Book – PageTurn</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .form-card {
        width: 50%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: auto;
    }

    .form-card label {
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }

    .form-card input,
    .form-card select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .form-card button {
        margin-top: 15px;
        padding: 10px 18px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .form-card button:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">✏️ Edit Book</h1>

        <form method="POST" class="form-card">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

            <label>Author</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

            <label>Genre</label>
            <select name="genre" required>
                <option value="<?= htmlspecialchars($book['genre']) ?>" selected>
                    <?= htmlspecialchars($book['genre']) ?>
                </option>
                <option value="Business">Business</option>
                <option value="Productivity">Productivity</option>
                <option value="Fiction">Fiction</option>
                <option value="Memoir">Memoir</option>
                <option value="Science">Science</option>
            </select>

            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $book['price'] ?>" required>

            <label>Stock</label>
            <input type="number" name="stock" value="<?= $book['stock'] ?>" required>

            <label>Rating</label>
            <input type="number" step="0.1" max="5" name="rating" value="<?= $book['rating'] ?>" required>

            <button type="submit">Update Book</button>
        </form>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <br><a href="improved_books.php">⬅ Back to Books</a>
    </div>
</body>

</html>