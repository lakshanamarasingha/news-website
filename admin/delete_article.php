<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Delete image from uploads folder
$result = mysqli_query($conn, "SELECT image FROM articles WHERE id=$id");
$article = mysqli_fetch_assoc($result);
if($article['image']){
    unlink("../uploads/" . $article['image']);
}

// Delete article from database
mysqli_query($conn, "DELETE FROM articles WHERE id=$id");

header("Location: dashboard.php");
exit();
?>