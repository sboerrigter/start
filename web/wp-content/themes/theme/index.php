<?php
$pageId = get_option('page_for_posts');

// Title
if (is_author()) {
  $label = __('Articles by', 'theme');
  $author = get_the_author();
  $title = "{$label} {$author}";
} elseif (is_category() || is_tag() || is_tax()) {
  $term = get_queried_object();

  if ($term && isset($term->name)) {
    $label = __('Articles about', 'theme');
    $title = "{$label} &ldquo;{$term->name}&rdquo;";
  }
} else {
  $title = get_the_title($pageId);
}
?>

<?= component('head'); ?>
<?= component('header'); ?>
<?= component('hero', ['image' => get_field('_thumbnail_id', $pageId)]); ?>

<main class="section">
  <div class="wrapper">
    <h1><?= $title ?></h1>
    <?= component('posts'); ?>
  </div>
</main>

<?= component('cta'); ?>
<?= component('footer'); ?>
