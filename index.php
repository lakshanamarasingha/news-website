<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NewsToday</title>
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
    <button class="hamburger" onclick="toggleNav()">&#9776;</button>
    <div class="nav-links" id="navLinks">
      <a href="index.php" class="active">Home</a>
      <a href="category.php?cat=Top Stories">Top Stories</a>
      <a href="category.php?cat=World">World</a>
      <a href="category.php?cat=Technology">Tech</a>
      <a href="category.php?cat=Sports">Sports</a>
      <a href="category.php?cat=Health">Health</a>
      <a href="category.php?cat=Business">Business</a>
      <a href="category.php?cat=Opinion">Opinion</a>
      <a href="category.php?cat=Local">Local</a>
      <a href="about.php">About Us</a>
      <a href="contact.php">Contact</a>
      <a href="admin/login.php" class="admin-link">Admin</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<div class="hero">
  <div class="hero-tag">Welcome to NewsToday</div>
  <h1>Stay Informed. Stay Ahead.</h1>
  <p>Breaking news, in-depth analysis, and stories that matter — delivered fresh every day.</p>
</div>
<!-- Top Stories Slideshow -->
<?php
  $slides = mysqli_query($conn, "SELECT * FROM articles WHERE category='Top Stories' ORDER BY created_at DESC LIMIT 5");
  $slides_arr = mysqli_fetch_all($slides, MYSQLI_ASSOC);
?>
<?php if(!empty($slides_arr)): ?>
<div class="slideshow-wrap">
  <div class="slideshow">
    <?php foreach($slides_arr as $i => $s): ?>
    <a href="article.php?id=<?= $s['id'] ?>" class="slide <?= $i === 0 ? 'active' : '' ?>">
      <?php if(!empty($s['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($s['image']) ?>" alt="">
      <?php else: ?>
        <div class="slide-placeholder"></div>
      <?php endif; ?>
      <div class="slide-overlay">
        <span class="badge badge-breaking">Top Story</span>
        <h2><?= htmlspecialchars($s['title']) ?></h2>
        <p><?= htmlspecialchars(substr($s['content'], 0, 120)) ?>...</p>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
  <button class="slide-btn prev" onclick="moveSlide(-1)">&#8592;</button>
  <button class="slide-btn next" onclick="moveSlide(1)">&#8594;</button>
  <div class="slide-dots">
    <?php foreach($slides_arr as $i => $s): ?>
      <span class="dot <?= $i === 0 ? 'active' : '' ?>" onclick="goSlide(<?= $i ?>)"></span>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- Main Content -->
<!-- Main Content -->
<div class="main-layout">
  <div class="categories-grid">

    <?php
   $categories = [
  'Top Stories' => 'Top Stories',
  'World'       => 'World',
  'Technology'  => 'Tech',
  'Sports'      => 'Sports',
  'Health'      => 'Health',
  'Business'    => 'Business',
  'Opinion'     => 'Opinion',
  'Local'       => 'Local',
];

    foreach($categories as $cat => $label):
      $cat_result = mysqli_query($conn, "SELECT * FROM articles WHERE category='$cat' ORDER BY created_at DESC LIMIT 3");
      if(mysqli_num_rows($cat_result) === 0) continue;
    ?>

    <div class="category-section">
      <a href="category.php?cat=<?= urlencode($cat) ?>" class="section-title-link">
        <h2 class="section-title"><?= $label ?> <span class="section-arrow">→</span></h2>
      </a>

      <div class="news-grid">
        <?php while($row = mysqli_fetch_assoc($cat_result)): ?>
        <a href="article.php?id=<?= $row['id'] ?>" class="news-card">

          <?php if(!empty($row['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
          <?php else: ?>
            <div style="height:160px; background: linear-gradient(135deg,#0C2D55,#185FA5); display:flex; align-items:center; justify-content:center;">
              <span style="color:#B5D4F4; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">NewsToday</span>
            </div>
          <?php endif; ?>

          <div class="news-card-body">
            <?php
              $badgeMap = [
                'World' => 'badge-world', 'Technology' => 'badge-tech',
                'Sports' => 'badge-sports', 'Top Stories' => 'badge-breaking',
                'Health' => 'badge-breaking', 'Opinion' => 'badge-opinion',
                'Local' => 'badge-local'
              ];
              $badgeClass = $badgeMap[$row['category']] ?? 'badge-default';
            ?>
            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['category']) ?></span>
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
    </div>

    <?php endforeach; ?>

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

  var current = 0;
  var slides = document.querySelectorAll('.slide');
  var dots = document.querySelectorAll('.dot');

  function goSlide(n) {
    if(slides.length === 0) return;
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
  }

  function moveSlide(dir) { goSlide(current + dir); }
  setInterval(function() { moveSlide(1); }, 5000);
</script>

</body>
</html>