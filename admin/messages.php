<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$messages = mysqli_query($conn, "SELECT * FROM contacts ORDER BY created_at DESC");
$total = mysqli_num_rows($messages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages — NewsToday Admin</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Admin Topbar -->
<div class="admin-topbar">
  <div class="logo">News<span>Today</span> <span style="font-size:13px; font-weight:400; color:var(--blue-200); margin-left:8px;">Admin Panel</span></div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_article.php">Add Article</a>
    <a href="messages.php" style="color:#fff;">Messages</a>
    <a href="../index.php">View Site</a>
    <a href="logout.php" style="color:var(--red);">Logout</a>
  </nav>
</div>

<div class="admin-body">

  <div class="admin-page-title">Messages <span style="font-size:16px; font-weight:500; color:var(--gray-500);">(<?= $total ?> total)</span></div>

  <?php if($total === 0): ?>
    <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:48px; text-align:center; color:var(--gray-500);">
      <div style="font-size:48px; margin-bottom:16px;">📭</div>
      <h3 style="font-size:18px; color:var(--gray-700); margin-bottom:8px;">No messages yet</h3>
      <p>When readers contact you, their messages will appear here.</p>
    </div>

  <?php else: ?>
    <div class="admin-table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while($row = mysqli_fetch_assoc($messages)): ?>
          <tr>
            <td style="color:var(--gray-500);"><?= $i++ ?></td>
            <td style="font-weight:600;"><?= htmlspecialchars($row['name']) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>" style="color:var(--blue-600);"><?= htmlspecialchars($row['email']) ?></a></td>
            <td><span class="badge badge-world" style="margin:0;"><?= htmlspecialchars($row['subject']) ?></span></td>
            <td style="max-width:300px; color:var(--gray-700);"><?= htmlspecialchars(substr($row['message'], 0, 80)) ?>...</td>
            <td style="color:var(--gray-500); white-space:nowrap;"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

</div>

</body>
</html>