<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us — NewsToday</title>
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
      <a href="about.php">About Us</a>
      <a href="contact.php" class="active">Contact</a>
      <a href="admin/login.php" class="admin-link">Admin</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<div class="hero">
  <div class="hero-tag">Get In Touch</div>
  <h1>Contact Us</h1>
  <p>Have a news tip, story idea, or feedback? We'd love to hear from you.</p>
</div>

<!-- Content -->
<div class="container" style="padding-top:48px; padding-bottom:80px;">
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px; max-width:1000px; margin:0 auto;">

    <!-- Contact Form -->
    <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:36px;">
      <h2 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:24px; padding-bottom:14px; border-bottom:2px solid var(--gray-200);">Send us a Message</h2>

      <?php if(isset($_GET['sent'])): ?>
        <div class="alert alert-success">Your message has been sent successfully!</div>
      <?php endif; ?>

      <form method="POST" action="send_contact.php">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Enter your full name" required>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label>Subject</label>
          <select name="subject">
            <option value="News Tip">News Tip</option>
            <option value="Story Idea">Story Idea</option>
            <option value="Feedback">Feedback</option>
            <option value="Advertising">Advertising</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" rows="6" placeholder="Write your message here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Send Message</button>
      </form>
    </div>

    <!-- Contact Info -->
    <div style="display:flex; flex-direction:column; gap:16px;">

      <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:28px; border-top:4px solid var(--blue-600);">
        <h3 style="font-size:16px; font-weight:800; color:var(--gray-900); margin-bottom:8px;">Editorial Office</h3>
        <p style="font-size:14px; color:var(--gray-500); line-height:1.7;">No. 42, Galle Road, Colombo 03, Sri Lanka</p>
      </div>

      <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:28px; border-top:4px solid var(--blue-400);">
        <h3 style="font-size:16px; font-weight:800; color:var(--gray-900); margin-bottom:8px;">Email Us</h3>
        <p style="font-size:14px; color:var(--gray-500); line-height:1.7;">
          News Tips: <a href="mailto:tips@newstoday.lk" style="color:var(--blue-600);">tips@newstoday.lk</a><br>
          General: <a href="mailto:hello@newstoday.lk" style="color:var(--blue-600);">hello@newstoday.lk</a>
        </p>
      </div>

      <div style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:28px; border-top:4px solid #639922;">
        <h3 style="font-size:16px; font-weight:800; color:var(--gray-900); margin-bottom:8px;">Working Hours</h3>
        <p style="font-size:14px; color:var(--gray-500); line-height:1.7;">
          Monday — Friday: 8:00 AM – 8:00 PM<br>
          Saturday: 9:00 AM – 5:00 PM<br>
          Sunday: Emergency news only
        </p>
      </div>

      <div style="background:var(--blue-900); border-radius:var(--radius-lg); padding:28px; text-align:center;">
        <h3 style="font-size:16px; font-weight:800; color:#fff; margin-bottom:8px;">Follow Us</h3>
        <p style="font-size:14px; color:var(--blue-100); margin-bottom:16px;">Stay updated on social media</p>
        <div style="display:flex; gap:10px; justify-content:center;">
          <span style="background:var(--blue-600); color:#fff; padding:8px 18px; border-radius:var(--radius); font-size:13px; font-weight:600;">Facebook</span>
          <span style="background:var(--blue-400); color:#fff; padding:8px 18px; border-radius:var(--radius); font-size:13px; font-weight:600;">Twitter</span>
          <span style="background:#C13584; color:#fff; padding:8px 18px; border-radius:var(--radius); font-size:13px; font-weight:600;">Instagram</span>
        </div>
      </div>

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