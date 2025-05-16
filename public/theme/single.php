<?= component('head') ?>
<?= component('header') ?>
<?= component('hero', ['image' => false]) ?>

<section>
  <div class="content">
    <?= component('post-image') ?>

    <h1 class="mb-0">
      <?= get_the_title() ?>
    </h1>

    <?= component('post-meta') ?>
    <?= get_the_content() ?>
    <?= component('post-tags') ?>
    <?= component('share') ?>
  </div>
</section>

<?= component('related-posts') ?>
<?= component('cta') ?>
<?= component('footer') ?>
