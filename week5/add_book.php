<?php
include("db_connect.php"); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);

    if (!empty($title) && !empty($author)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $author);

        if ($stmt->execute()) {
            header("Location: books.php?success=1");
            exit();
        } else {
            $error = " Error adding book: " . $conn->error;
        }
    } else {
        $error = " Please fill in all fields.";
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
        height: 100vh;
        color: #003366;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 380px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #003366;
        font-weight: bold;
    }

    input {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        background: rgba(255, 255, 255, 0.4);
        color: #003366;
    }

    button {
        padding: 12px 20px;
        background: #0072ff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        width: 95%;
    }

    button:hover {
        background: #005fcc;
    }

    .error {
        color: #ff4d4d;
        margin-top: 10px;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2> Add New Book</h2>
        <form method="POST" action="">
            <input type="text" name="title" placeholder="Enter book title"><br>
            <input type="text" name="author" placeholder="Enter author name"><br>
            <button type="submit">Add Book</button>
        </form>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <div class="links">
            <a href="books.php"> Back to Books</a>
        </div>
    </div>
</body>

</html>