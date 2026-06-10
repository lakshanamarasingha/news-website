<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM articles WHERE id=$id");
$article = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $content  = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    if(!empty($_FILES['image']['name'])){
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
    } else {
        $image = $article['image'];
    }

    mysqli_query($conn, "UPDATE articles SET title='$title', content='$content', category='$category', image='$image' WHERE id=$id");
    $success = "Article updated successfully!";

    $result = mysqli_query($conn, "SELECT * FROM articles WHERE id=$id");
    $article = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Article — NewsToday Admin</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Admin Topbar -->
<div class="admin-topbar">
  <div class="logo">News<span>Today</span> <span style="font-size:13px; font-weight:400; color:var(--blue-200); margin-left:8px;">Admin Panel</span></div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_article.php">Add Article</a>
    <a href="../index.php">View Site</a>
    <a href="logout.php" style="color:var(--red);">Logout</a>
  </nav>
</div>

<!-- Body -->
<div class="admin-body">

  <div class="admin-page-title">Edit Article</div>

  <?php if(isset($success)): ?>
    <div class="alert alert-success" style="max-width:820px;"><?= $success ?></div>
  <?php endif; ?>

  <div class="admin-form">
    <h2>Article Details</h2>

    <form method="POST" action="" enctype="multipart/form-data">

      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php
            $cats = ['Top Stories','World','Technology','Sports','Health','Business','Opinion','Local'];
            foreach($cats as $c):
          ?>
          <option value="<?= $c ?>" <?= $article['category']==$c ? 'selected' : '' ?>><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Content</label>
        <textarea name="content" rows="14" required><?= htmlspecialchars($article['content']) ?></textarea>
      </div>

      <div class="form-group">
        <label>Current Image</label>
        <?php if(!empty($article['image'])): ?>
          <div style="margin:12px 0;">
            <img src="../uploads/<?= htmlspecialchars($article['image']) ?>" style="width:100%; max-width:360px; height:200px; object-fit:cover; border-radius:var(--radius-lg); border:1px solid var(--gray-200);">
          </div>
        <?php endif; ?>
        <label>Replace Image <span style="font-weight:400; color:var(--gray-500);">(optional)</span></label>
        <input type="file" name="image" accept="image/*">
        <p style="font-size:12px; color:var(--gray-500); margin-top:6px;">Leave empty to keep the current image.</p>
      </div>

      <div class="form-actions">
        <button type="submit" name="submit" class="btn btn-primary">Update Article</button>
        <a href="dashboard.php" class="btn btn-outline">← Back to Dashboard</a>
      </div>

    </form>
  </div>

</div>

</body>
</html>