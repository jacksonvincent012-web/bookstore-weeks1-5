<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];

    $update = "UPDATE books SET title='$title', author='$author' WHERE id=$id";
    if(mysqli_query($conn, $update)){
        header("Location: books.php");
        exit();
    } else {
        $error = "Error updating book!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h2>✏️ Edit Book</h2>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br><br>
        <label>Author:</label><br>
        <input type="text" name="author" value="<?php echo $book['author']; ?>" required><br><br>
        <button type="submit">Update Book</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <br><a href="books.php">⬅ Back to Books</a>
</body>
</html>
