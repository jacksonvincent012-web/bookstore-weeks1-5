<?php
session_start();
include("db_connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE books SET title=?, author=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $author, $id);
    $stmt->execute();

    header("Location: improved_books.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Book</title>
</head>

<body>
    <h2>✏️ Edit Book</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
        <input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
        <button type="submit">Update Book</button>
    </form>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</body>

</html>