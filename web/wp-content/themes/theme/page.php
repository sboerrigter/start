<?= component('head'); ?>
<?= component('header'); ?>
<?= component('hero'); ?>

<main>
  <div class="wrapper max-w-content">
    <h1><?= get_the_title(); ?></h1>
    <?= apply_filters('the_content', get_the_content()); ?>
  </div>
</main>

<?= component('cta'); ?>
<?= component('footer'); ?>
