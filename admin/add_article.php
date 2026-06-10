<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $content  = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $image = '';
    if(!empty($_FILES['image']['name'])){
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
    }

    mysqli_query($conn, "INSERT INTO articles (title, content, category, image) VALUES ('$title', '$content', '$category', '$image')");
    $success = "Article published successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Article — NewsToday Admin</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Admin Topbar -->
<div class="admin-topbar">
  <div class="logo">News<span>Today</span> <span style="font-size:13px; font-weight:400; color:var(--blue-200); margin-left:8px;">Admin Panel</span></div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_article.php" style="color:#fff;">Add Article</a>
    <a href="../index.php">View Site</a>
    <a href="logout.php" style="color:var(--red);">Logout</a>
  </nav>
</div>

<!-- Body -->
<div class="admin-body">

  <div class="admin-page-title">Add New Article</div>

  <?php if(isset($success)): ?>
    <div class="alert alert-success" style="max-width:820px;"><?= $success ?></div>
  <?php endif; ?>

  <div class="admin-form">
    <h2>Article Details</h2>

    <form method="POST" action="" enctype="multipart/form-data">

      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" placeholder="Enter article title" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <option value="Top Stories">Top Stories</option>
          <option value="World">World</option>
          <option value="Technology">Technology</option>
          <option value="Sports">Sports</option>
          <option value="Health">Health</option>
          <option value="Business">Business</option>
          <option value="Opinion">Opinion</option>
          <option value="Local">Local</option>
        </select>
      </div>

      <div class="form-group">
        <label>Content</label>
        <textarea name="content" rows="12" placeholder="Write article content..." required></textarea>
      </div>

      <div class="form-group">
        <label>Article Image</label>
        <input type="file" name="image" accept="image/*">
        <p style="font-size:12px; color:var(--gray-500); margin-top:6px;">Recommended size: 1200×600px. JPG or PNG.</p>
      </div>

      <div class="form-actions">
        <button type="submit" name="submit" class="btn btn-primary">Publish Article</button>
        <a href="dashboard.php" class="btn btn-outline">← Back to Dashboard</a>
      </div>

    </form>
  </div>

</div>

</body>
</html>