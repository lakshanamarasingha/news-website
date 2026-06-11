<?php
include 'db.php';

$name    = mysqli_real_escape_string($conn, $_POST['name']);
$email   = mysqli_real_escape_string($conn, $_POST['email']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

mysqli_query($conn, "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')");

header("Location: contact.php?sent=1");
exit;
?>