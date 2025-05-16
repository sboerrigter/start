<?= component('head') ?>
<?= component('header') ?>
<?= component('hero') ?>

<section>
  <div class="content">
    <h1><?= get_the_title() ?></h1>
    <?= get_the_content() ?>
  </div>
</section>

<?= component('cta') ?>
<?= component('footer') ?>
