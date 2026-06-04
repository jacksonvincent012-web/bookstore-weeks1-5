<?php
include("db_connect.php");

$result = mysqli_query($conn, "SELECT * FROM books");

echo "<h2>Bookstore Catalog</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Title</th><th>Author</th><th>Price</th><th>Stock</th></tr>";

while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['title']."</td>";
    echo "<td>".$row['author']."</td>";
    echo "<td>".$row['price']."</td>";
    echo "<td>".$row['stock']."</td>";
    echo "</tr>";
}

echo "</table>";
