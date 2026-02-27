<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($title ?? 'Untitled') ?></title>

    <!-- Font Awesome (CDN) - nav and footer icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />

    <!-- Global styling (always loaded on every page) -->
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="/styles/layout.css" />
    <link rel="stylesheet" href="/styles/cards.css" />

    <!-- 
      Page-specific styles.
      The controller can pass an array called 'styles'.
      Example from controller:
        'styles' => ['home.css']

      If $styles exists and is not empty:
        - Loop through each filename
        - Output a <link> tag dynamically
        - htmlspecialchars() prevents XSS if someone injects bad data
    -->
    <?php if (!empty($styles)): ?>
      <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" href="/styles/<?= htmlspecialchars($style) ?>">
      <?php endforeach; ?>
    <?php endif; ?>

  </head>
  <body>
    <!-- Main navigation:
         logo on the left, primary links in the middle, account pushed to the right -->
    <nav class="nav">
      <a href="home.html">
        <img class="logo" src="../assets/logo.png" alt="Events Portal Logo" />
      </a>

      <a class="nav-item" href="events.html.php">
        <i class="fa-solid fa-calendar"></i>
        <span class="nav-text">Events</span>
      </a>

      <a class="nav-item" href="#">
        <i class="fa-solid fa-circle-info"></i>
        <span class="nav-text">About</span>
      </a>

      <a class="nav-item" href="#">
        <i class="fa-solid fa-envelope"></i>
        <span class="nav-text">Contact</span>
      </a>

      <a class="account nav-item" href="#">
        <i class="fa-solid fa-user"></i>
        <span class="nav-text">Account</span>
      </a>
    </nav>
    <!-- Main content area:
        the controller will inject page-specific content here -->
    <main class="main">
        <?= $content ?>
    </main>

    <!-- Footer:
         socials + newsletter sign-up + copyright -->
    <footer class="footer">
      <span class="social-text">Follow us on social media</span>

      <div class="social-links">
        <a class="social-icon" href="#">
          <i class="fa-brands fa-facebook"></i>
        </a>
        <a class="social-icon" href="#">
          <i class="fa-brands fa-twitter"></i>
        </a>
        <a class="social-icon" href="#">
          <i class="fa-brands fa-instagram"></i>
        </a>
      </div>

      <div class="newsletter-form">
        <span class="newsletter-text">Subscribe to our newsletter</span>
        <label for="newsletter-email" class="newsletter-email-label"
          >Email address</label
        >
        <form>
          <input
            type="email"
            name="newsletter-email"
            placeholder="Email Address"
          />
          <button type="submit" class="subscribe-submit">Subscribe</button>
        </form>
      </div>

      <span class="copyright">
        &copy; 2026 CSYM019 Assignment - Sergiu Popa
      </span>
    </footer>
  </body>
</html>
