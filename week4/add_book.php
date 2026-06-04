<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];

    $sql = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
    if(mysqli_query($conn, $sql)){
        // ✅ Redirect to improved_books.php instead of books.php
        header("Location: improved_books.php?success=1");
        exit();
    } else {
        $error = "❌ Error adding book: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book - Bookstore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #243b55, #141e30);
            color: #fff;
            text-align: center;
        }
        h2 {
            margin: 20px 0;
            color: #00c6ff;
            text-shadow: 0 0 10px #00c6ff;
        }
        form {
            background: rgba(0,0,0,0.5);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px #00c6ff;
        }
        input {
            padding: 10px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            width: 250px;
        }
        button {
            padding: 12px 20px;
            background: #00c6ff;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 0 10px #00c6ff;
            transition: 0.3s;
        }
        button:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #00c6ff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 0 10px #00c6ff;
            transition: 0.3s;
        }
        a:hover {
            background: #0072ff;
            box-shadow: 0 0 20px #0072ff;
        }
    </style>
</head>
<body>
    <h2>➕ Add New Book</h2>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Book Title" required><br>
        <input type="text" name="author" placeholder="Author Name" required><br>
        <button type="submit">Add Book</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <br><a href="improved_books.php">⬅ Back to Books</a>
</body>
</html>
