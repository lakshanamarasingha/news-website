<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - NewsToday</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Breaking Ticker -->
<div class="ticker">
  <span class="ticker-label">&#9733; Breaking</span>
  <div class="ticker-track">
    <span class="ticker-inner">
      Sri Lanka Economy Grows 5.2% in Q1 2026 — IMF Praises Reform Progress &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Colombo Port City Attracts $3 Billion in Foreign Investment &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Sri Lanka Cricket Qualifies for ICC Champions Trophy Final &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 5G Network Rollout Completed Across All Major Sri Lanka Cities &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Ceylon Tea Exports Cross $2 Billion Mark for First Time in History &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span>
  </div>
</div>

<!-- Navbar -->
<nav>
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">News<span>Today</span></a>
    <button class="hamburger" onclick="toggleNav()">&#9776;</button>
    <div class="nav-links" id="navLinks">
      <a href="index.php">Home</a>
      <a href="category.php?cat=Top Stories">Top Stories</a>
      <a href="category.php?cat=World">World</a>
      <a href="category.php?cat=Technology">Tech</a>
      <a href="category.php?cat=Sports">Sports</a>
      <a href="category.php?cat=Health">Health</a>
      <a href="category.php?cat=Business">Business</a>
      <a href="category.php?cat=Opinion">Opinion</a>
      <a href="category.php?cat=Local">Local</a>
      <a href="about.php" class="active">About Us</a>
      <a href="admin/login.php" class="admin-link">Admin</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<div class="hero">
  <div class="hero-tag">Who We Are</div>
  <h1>About NewsToday</h1>
  <p>Your trusted source for accurate, timely news from Sri Lanka and around the world.</p>
</div>

<!-- Content -->
<div class="container" style="padding-top:48px; padding-bottom:80px;">

  <div style="max-width:800px; margin:0 auto;">

    <!-- Mission -->
    <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:36px; margin-bottom:24px; border-top:4px solid var(--blue-600);">
      <h2 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:16px;">Our Mission</h2>
      <p style="font-size:16px; color:var(--gray-700); line-height:1.8;">NewsToday is committed to delivering accurate, timely, and unbiased news to readers across Sri Lanka and beyond. We believe an informed public is the foundation of a healthy society.</p>
    </div>

    <!-- What We Cover -->
    <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:36px; margin-bottom:24px; border-top:4px solid var(--blue-400);">
      <h2 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:16px;">What We Cover</h2>
      <div style="display:flex; flex-wrap:wrap; gap:10px;">
        <?php
          $cats = ['Top Stories','World','Technology','Sports','Health','Business','Opinion','Local'];
          $badgeMap = [
            'Top Stories'=>'badge-breaking','World'=>'badge-world',
            'Technology'=>'badge-tech','Sports'=>'badge-sports',
            'Health'=>'badge-breaking','Business'=>'badge-tech',
            'Opinion'=>'badge-opinion','Local'=>'badge-local'
          ];
          foreach($cats as $c):
            $bc = $badgeMap[$c] ?? 'badge-default';
        ?>
          <a href="category.php?cat=<?= urlencode($c) ?>">
            <span class="badge <?= $bc ?>" style="font-size:13px; padding:6px 16px;"><?= $c ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Values -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:16px; margin-bottom:24px;">
      <?php
        $values = [
          ['Accuracy', 'Every story is fact-checked before publishing.', '#185FA5'],
          ['Speed', 'Breaking news delivered within minutes.', '#378ADD'],
          ['Balance', 'Multiple perspectives on every story.', '#3B6D11'],
          ['Trust', 'Built on years of credible journalism.', '#534AB7'],
        ];
        foreach($values as $v):
      ?>
      <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:24px; border-top:4px solid <?= $v[2] ?>;">
        <h3 style="font-size:16px; font-weight:800; color:var(--gray-900); margin-bottom:8px;"><?= $v[0] ?></h3>
        <p style="font-size:14px; color:var(--gray-500); line-height:1.7;"><?= $v[1] ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Contact -->
    <div style="background:var(--blue-900); border-radius:var(--radius-lg); padding:36px; text-align:center;">
      <h2 style="font-size:20px; font-weight:800; color:#fff; margin-bottom:10px;">Get in Touch</h2>
      <p style="font-size:15px; color:var(--blue-100); margin-bottom:20px;">Have a tip or story idea? We'd love to hear from you.</p>
      <a href="mailto:news@newstoday.lk" style="display:inline-block; background:var(--blue-600); color:#fff; padding:12px 28px; border-radius:var(--radius); font-weight:700; font-size:15px;">news@newstoday.lk</a>
    </div>

  </div>
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