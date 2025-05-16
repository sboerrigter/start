<?= component('head') ?>
<?= component('header') ?>
<?= component('hero') ?>

<section>
  <div class="content">
    <h1><?= __('Page not found', 'theme') ?></h1>

    <p>
      <?= __(
        'Unfortunately, this page does not exist. You can go to the homepage, or use the menu above to navigate to other pages.',
        'theme'
      ) ?>
    </p>

    <?= component('button', [
      'title' => __('To the homepage', 'theme'),
      'url' => home_url(),
    ]) ?>
  </div>
</section>

<?= component('cta') ?>
<?= component('footer') ?>
