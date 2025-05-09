<?php
$uri = $_SERVER['REQUEST_URI'];

// Redirect /wp-admin and /wp-login.php to WordPress
if (strpos($uri, '/wp-admin') === 0 || strpos($uri, '/wp-login.php') === 0) {
  header("Location: /wp{$uri}");
  exit();
}

define('WP_USE_THEMES', true);
require __DIR__ . '/wp/wp-blog-header.php';
