<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav>
    <div class="logo">📰 NewsToday</div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="category.php">Categories</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="admin/login.php" class="login-btn">🔐 Login</a></li>
    </ul>
</nav>

    <div class="container">
        <div class="contact-page">
            <h2>📬 Contact Us</h2>
            <p>Have a news tip or question? Send us a message!</p>

            <?php
            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $message = $_POST['message'];
                echo "<div class='success-msg'>✅ Thank you $name! Your message has been sent.</div>";
            }
            ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="6" placeholder="Write your message..." required></textarea>
                </div>
                <button type="submit" name="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
    <footer>
    <p>© 2026 <span>NewsToday</span> — All rights reserved</p>
</footer>

</body>
</html>