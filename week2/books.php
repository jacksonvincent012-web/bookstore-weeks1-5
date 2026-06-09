<?php
include("db_connect.php");
session_start();

// Block access if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Fetch books
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Books – PageTurn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div class="main">
        <h1 class="page-title">📚 Books Catalog</h1>

        <div class="card-table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                </tr>

                <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No books found</td></tr>";
            }
            ?>
            </table>
        </div>
    </div>

</body>

</html>