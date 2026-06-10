<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$articles = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
$total = mysqli_num_rows($articles);

// Count by category
$cat_counts = [];
$cat_result = mysqli_query($conn, "SELECT category, COUNT(*) as cnt FROM articles GROUP BY category");
while($row = mysqli_fetch_assoc($cat_result)){
    $cat_counts[$row['category']] = $row['cnt'];
}

// Latest article date
$latest = mysqli_query($conn, "SELECT created_at FROM articles ORDER BY created_at DESC LIMIT 1");
$latest_row = mysqli_fetch_assoc($latest);
$latest_date = $latest_row ? date('M j, Y', strtotime($latest_row['created_at'])) : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — NewsToday</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Admin Topbar -->
<div class="admin-topbar">
  <div class="logo">News<span>Today</span> <span style="font-size:13px; font-weight:400; color:var(--blue-200); margin-left:8px;">Admin Panel</span></div>
  <nav>
    <a href="dashboard.php" style="color:#fff;">Dashboard</a>
    <a href="add_article.php">Add Article</a>
    <a href="../index.php">View Site</a>
    <a href="logout.php" style="color:var(--red);">Logout</a>
  </nav>
</div>

<!-- Dashboard Body -->
<div class="admin-body">

  <!-- Page Title -->
  <div class="admin-page-title">Dashboard</div>

  <!-- Stat Cards -->
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-label">Total Articles</div>
      <div class="stat-value"><?= $total ?></div>
    </div>
    <div class="stat-card" style="border-top-color:var(--blue-400);">
      <div class="stat-label">Latest Published</div>
      <div class="stat-value" style="font-size:20px; padding-top:6px;"><?= $latest_date ?></div>
    </div>
    <div class="stat-card" style="border-top-color:#639922;">
      <div class="stat-label">Categories Active</div>
      <div class="stat-value"><?= count($cat_counts) ?></div>
    </div>
    <div class="stat-card" style="border-top-color:var(--purple);">
      <div class="stat-label">Logged in as</div>
      <div class="stat-value" style="font-size:18px; padding-top:8px;"><?= htmlspecialchars($_SESSION['admin']) ?></div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div style="display:flex; gap:12px; margin-bottom:32px;">
    <a href="add_article.php" class="btn btn-primary">+ Add New Article</a>
    <a href="../index.php"class="btn btn-outline">View Site →</a>
  </div>

  <!-- Articles Table -->
  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Category</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        mysqli_data_seek($articles, 0);
        while($row = mysqli_fetch_assoc($articles)):
          $badgeMap = [
            'World'=>'badge-world','Technology'=>'badge-tech',
            'Sports'=>'badge-sports','Top Stories'=>'badge-breaking',
            'Health'=>'badge-breaking','Opinion'=>'badge-opinion',
            'Local'=>'badge-local','Business'=>'badge-tech',
          ];
          $bc = $badgeMap[$row['category']] ?? 'badge-default';
        ?>
        <tr>
          <td style="color:var(--gray-500); width:40px;"><?= $i++ ?></td>
          <td style="font-weight:600; max-width:400px;"><?= htmlspecialchars($row['title']) ?></td>
          <td><span class="badge <?= $bc ?>" style="margin:0;"><?= htmlspecialchars($row['category']) ?></span></td>
          <td style="color:var(--gray-500); white-space:nowrap;"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
          <td style="white-space:nowrap;">
            <a href="edit_article.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
            <a href="delete_article.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this article?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>