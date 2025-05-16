<?= component('head') ?>
<?= component('header') ?>
<?= component('hero', ['image' => false]) ?>

<section>
  <div class="content">
    <?= component('post-image') ?>

    <h1 class="mb-2">
      <?= get_the_title() ?>
    </h1>

    <?= component('post-meta', ['class' => 'md:mb-12']) ?>
    <?= get_the_content() ?>
    <?= component('post-tags') ?>
    <?= component('share') ?>
  </div>
</section>

<?= component('related-posts') ?>
<?= component('cta') ?>
<?= component('footer') ?>
