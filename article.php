<?php 
include 'db.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM articles WHERE id=$id");
$article = mysqli_fetch_assoc($result);

// Handle Like / Unlike
if(isset($_POST['like'])){
    $liked = isset($_COOKIE['liked_'.$id]);
    if($liked){
        $row_id = $_COOKIE['liked_'.$id];
        mysqli_query($conn, "DELETE FROM likes WHERE id=$row_id");
        setcookie('liked_'.$id, '', time()-3600, '/');
    } else {
        mysqli_query($conn, "INSERT INTO likes (article_id) VALUES ($id)");
        $row_id = mysqli_insert_id($conn);
        setcookie('liked_'.$id, $row_id, time()+86400*30, '/');
    }
    header("Location: article.php?id=$id");
    exit();
}

// Handle Comment
if(isset($_POST['submit_comment'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment_text']);
    mysqli_query($conn, "INSERT INTO comments (article_id, name, comment) VALUES ($id, '$name', '$comment')");
    header("Location: article.php?id=$id");
    exit();
}

// Get likes count
$likes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM likes WHERE article_id=$id"));
$like_count = $likes['total'];

// Get comments
$comments = mysqli_query($conn, "SELECT * FROM comments WHERE article_id=$id ORDER BY created_at DESC");
$comment_count = mysqli_num_rows($comments);

// Badge map
$badgeMap = [
  'World' => 'badge-world', 'Technology' => 'badge-tech',
  'Sports' => 'badge-sports', 'Top Stories' => 'badge-breaking',
  'Health' => 'badge-breaking', 'Opinion' => 'badge-opinion',
  'Local' => 'badge-local', 'Business' => 'badge-default'
];
$badgeClass = $badgeMap[$article['category']] ?? 'badge-default';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($article['title']) ?> — NewsToday</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Breaking Ticker -->
<div class="ticker">
  <span class="ticker-label">&#9733; Breaking</span>
  <div class="ticker-track">
    <span class="ticker-inner">
  Sri Lanka Economy Grows 5.2% in Q1 2026 — IMF Praises Reform Progress &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Colombo Port City Attracts $3 Billion in Foreign Investment &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Sri Lanka Cricket Qualifies for ICC Champions Trophy Final &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 5G Network Rollout Completed Across All Major Sri Lanka Cities &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Ceylon Tea Exports Cross $2 Billion Mark for First Time in History &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; UN Declares Global Water Crisis Emergency — 2 Billion Affected &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Google Unveils Willow 2.0 Quantum Computer — Fastest Ever Built &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>
  </div>
</div>

<!-- Navbar -->
<nav>
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">News<span>Today</span></a>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="category.php?cat=Top Stories">Top Stories</a>
      <a href="category.php?cat=World">World</a>
      <a href="category.php?cat=Technology">Tech</a>
      <a href="category.php?cat=Sports">Sports</a>
      <a href="category.php?cat=Health">Health</a>
      <a href="category.php?cat=Business">Business</a>
      <a href="category.php?cat=Opinion">Opinion</a>
      <a href="category.php?cat=Local">Local</a>
      <a href="about.php">About Us</a>
      <a href="admin/login.php" class="admin-link">Admin</a>
    </div>
  </div>
</nav>

<!-- Article -->
<div class="article-page">
  <main>
    <div class="article-header">
      <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($article['category']) ?></span>
      <h1><?= htmlspecialchars($article['title']) ?></h1>
      <div class="article-meta">
        <span>🕒 <?= date('F j, Y', strtotime($article['created_at'])) ?></span>
      </div>
    </div>

    <?php if(!empty($article['image'])): ?>
      <img src="uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="article-cover">
    <?php endif; ?>

    <div class="article-body">
      <?php foreach(explode("\n", $article['content']) as $para): ?>
        <?php if(trim($para)): ?>
          <p><?= htmlspecialchars(trim($para)) ?></p>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <!-- Like Button -->
    <div class="like-section">
      <?php $liked = isset($_COOKIE['liked_'.$id]); ?>
      <form method="POST">
        <button type="submit" name="like" class="like-btn <?= $liked ? 'liked' : '' ?>">
          <?= $liked ? '👍 Liked' : '👍 Like' ?> <span><?= $like_count ?></span>
        </button>
      </form>
    </div>

    <!-- Comments -->
    <div class="comments-section">
      <h3>💬 Comments (<?= $comment_count ?>)</h3>

      <div class="comment-form">
        <form method="POST">
          <div class="form-group">
            <label>Your Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group">
            <label>Comment</label>
            <textarea name="comment_text" rows="4" placeholder="Write a comment..." required></textarea>
          </div>
          <button type="submit" name="submit_comment" class="btn btn-primary">Post Comment</button>
        </form>
      </div>

      <div class="comments-list">
        <?php while($row = mysqli_fetch_assoc($comments)): ?>
        <div class="comment-card">
          <div class="comment-header">
            <span class="comment-name">👤 <?= htmlspecialchars($row['name']) ?></span>
            <span class="comment-date"><?= date('M j, Y', strtotime($row['created_at'])) ?></span>
          </div>
          <p><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <a href="index.php" class="btn btn-outline" style="margin-top:24px; display:inline-flex;">← Back to Home</a>
  </main>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2026 <span>NewsToday</span> &mdash; All rights reserved</p>
</footer>

</body>
</html>