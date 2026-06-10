<?php
session_start();
include '../db.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $user = mysqli_fetch_assoc($result);

    if($user){
        $_SESSION['admin'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — NewsToday</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="login-page">
  <div class="login-card">

    <!-- Logo -->
    <div class="logo">News<span>Today</span></div>
    <p class="subtitle">Admin Portal — Sign in to continue</p>

    <!-- Error -->
    <?php if(isset($error)): ?>
      <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="">

      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required autocomplete="username">
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
      </div>

      <button type="submit" name="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px;">
        Sign In
      </button>

    </form>

    <p style="text-align:center; margin-top:20px; font-size:13px; color:var(--gray-500);">
      <a href="../index.php" style="color:var(--blue-600); font-weight:600;">← Back to NewsToday</a>
    </p>

  </div>
</div>

</body>
</html>