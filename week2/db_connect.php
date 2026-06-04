<?php
$conn = mysqli_connect("localhost", "root", "", "bookstoredb");
if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
