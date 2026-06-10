<?php
include 'db.php';
$category = $_GET['cat'] ?? '';

$badgeMap = [
  'World'      => 'badge-world',
  'Technology' => 'badge-tech',
  'Sports'     => 'badge-sports',
  'Health'     => 'badge-breaking',
  'Opinion'    => 'badge-opinion',
  'Local'      => 'badge-local',
  'Politics'   => 'badge-world',
  'Business'   => 'badge-tech',
  'Top Stories'=> 'badge-breaking',
];
$cats = ['Sports','Technology','Politics','Health','Business','Top Stories','World','Local','Opinion'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $category ? htmlspecialchars($category).' - NewsToday' : 'Categories - NewsToday' ?></title>
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
<!-- Navbar -->
<nav>
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">News<span>Today</span></a>
    <button class="hamburger" onclick="toggleNav()">&#9776;</button>
    <div class="nav-links" id="navLinks">
      <a href="index.php">Home</a>
      <a href="category.php?cat=Top Stories" class="<?= $category==='Top Stories' ? 'active' : '' ?>">Top Stories</a>
      <a href="category.php?cat=World" class="<?= $category==='World' ? 'active' : '' ?>">World</a>
      <a href="category.php?cat=Technology" class="<?= $category==='Technology' ? 'active' : '' ?>">Tech</a>
      <a href="category.php?cat=Sports" class="<?= $category==='Sports' ? 'active' : '' ?>">Sports</a>
      <a href="category.php?cat=Health" class="<?= $category==='Health' ? 'active' : '' ?>">Health</a>
      <a href="category.php?cat=Business" class="<?= $category==='Business' ? 'active' : '' ?>">Business</a>
      <a href="category.php?cat=Opinion" class="<?= $category==='Opinion' ? 'active' : '' ?>">Opinion</a>
      <a href="category.php?cat=Local" class="<?= $category==='Local' ? 'active' : '' ?>">Local</a>
      <a href="about.php">About Us</a>
      <a href="admin/login.php" class="admin-link">Admin</a>
    </div>
  </div>
</nav>

<!-- Page Hero -->
<div class="hero" style="padding:36px 24px;">
  <?php if($category): ?>
    <div class="hero-tag">Category</div>
    <h1 style="font-size:clamp(22px,4vw,36px)"><?= htmlspecialchars($category) ?></h1>
    <p>Browsing all articles in <strong><?= htmlspecialchars($category) ?></strong></p>
  <?php else: ?>
    <div class="hero-tag">Browse</div>
    <h1 style="font-size:clamp(22px,4vw,36px)">All Categories</h1>
    <p>Select a category below to explore stories</p>
  <?php endif; ?>
</div>

<div class="container" style="padding-top:32px; padding-bottom:60px;">


  <!-- Articles Grid -->
  <?php if($category):
    $safe = mysqli_real_escape_string($conn, $category);
    $result = mysqli_query($conn, "SELECT * FROM articles WHERE category='$safe' ORDER BY created_at DESC");
    $count = mysqli_num_rows($result);
  ?>

  <?php if($count > 0): ?>
    <h2 class="section-title"><?= htmlspecialchars($category) ?></h2>
    <div class="news-grid">
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <a href="article.php?id=<?= $row['id'] ?>" class="news-card">

          <?php if(!empty($row['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
          <?php else: ?>
            <div style="height:200px; background:linear-gradient(135deg,#0C2D55,#185FA5); display:flex; align-items:center; justify-content:center;">
              <span style="color:#B5D4F4; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">NewsToday</span>
            </div>
          <?php endif; ?>

          <div class="news-card-body">
            <?php $bc = $badgeMap[$row['category']] ?? 'badge-default'; ?>
            <span class="badge <?= $bc ?>"><?= htmlspecialchars($row['category']) ?></span>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars(substr($row['content'], 0, 120)) ?>...</p>
            <div class="news-card-meta">
              <span><?= date('M j, Y', strtotime($row['created_at'])) ?></span>
              <span class="read-more">Read more →</span>
            </div>
          </div>

        </a>
      <?php endwhile; ?>
    </div>

  <?php else: ?>
    <div style="text-align:center; padding:60px 20px; color:var(--gray-500);">
      <div style="font-size:48px; margin-bottom:16px;">📭</div>
      <h3 style="font-size:18px; color:var(--gray-700); margin-bottom:8px;">No articles yet</h3>
      <p>Nothing published in <strong><?= htmlspecialchars($category) ?></strong> yet. Check back soon!</p>
    </div>
  <?php endif; ?>

  <?php else: ?>
    <!-- No category selected — show all categories as cards -->
    <h2 class="section-title">Browse by Category</h2>
    <div class="news-grid" style="grid-template-columns: repeat(3, 1fr); gap: 20px;">
      <?php foreach($cats as $c):
        $bc = $badgeMap[$c] ?? 'badge-default';
      ?>
        <a href="category.php?cat=<?= urlencode($c) ?>" class="news-card" style="text-decoration:none;">
          <div style="height:120px; background:linear-gradient(135deg,#0C2D55,#185FA5); display:flex; align-items:center; justify-content:center;">
            <span style="color:#fff; font-size:22px; font-weight:800; letter-spacing:-0.5px;"><?= htmlspecialchars($c) ?></span>
          </div>
          <div class="news-card-body">
            <span class="badge <?= $bc ?>"><?= htmlspecialchars($c) ?></span>
            <h3>Browse <?= htmlspecialchars($c) ?> articles</h3>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

<!-- Footer -->
<footer>
  <p>&copy; 2026 <span>NewsToday</span> &mdash; All rights reserved</p>
</footer>
<script>
  function toggleNav() {
    document.getElementById('navLinks').classList.toggle('open');
  }
</script>
</body>
</html>