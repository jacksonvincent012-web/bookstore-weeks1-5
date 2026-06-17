<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die(" No book ID provided.");
}

$id = intval($_GET['id']); // safer
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);

if(!$result || mysqli_num_rows($result) == 0){
    die(" Book not found.");
}

$book = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $rating = $_POST['rating'];

    $update = "UPDATE books 
               SET title='$title', author='$author', genre='$genre', 
                   price='$price', stock='$stock', rating='$rating' 
               WHERE id=$id";
    if(mysqli_query($conn, $update)){
        header("Location: improved_books.php?updated=1");
        exit();
    } else {
        $error = " Error updating book: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Book – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title"> Edit Book</h1>

        <form method="POST" class="form-card">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

            <label>Author</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

            <label>Genre</label>
            <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>

            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $book['price'] ?>" required>

            <label>Stock</label>
            <input type="number" name="stock" value="<?= $book['stock'] ?>" required>

            <label>Rating</label>
            <input type="number" step="0.1" max="5" name="rating" value="<?= $book['rating'] ?>" required>

            <button type="submit">Update Book</button>
        </form>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>

</html>