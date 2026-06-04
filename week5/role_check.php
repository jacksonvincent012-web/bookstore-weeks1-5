<?php
session_start();
if(!isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}

function checkRole($requiredRole){
    if($_SESSION['role'] !== $requiredRole){
        echo "Access Denied!";
        exit();
    }
}
?>