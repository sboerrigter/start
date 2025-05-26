<?php
$url = urlencode($post->link());
$title = urlencode($post->title());

$buttons = [
  [
    'title' => __('E-mail this article', 'theme'),
    'href' => "mailto:?subject={$title}&amp;body={$url}",
    'icon' => 'mail',
  ],
  [
    'title' => __('Share this article via WhatsApp', 'theme'),
    'href' => "https://wa.me?text={$title}%20-%20{$url}",
    'icon' => 'whatsapp',
  ],
  [
    'title' => __('Share this article on LinkedIn', 'theme'),
    'href' => "https://www.linkedin.com/shareArticle?url={$url}",
    'icon' => 'linkedin',
  ],
  [
    'title' => __('Share this article on Facebook', 'theme'),
    'href' => "https://www.facebook.com/sharer.php?u={$url}",
    'icon' => 'facebook',
  ],
  [
    'title' => __('Share this article on X', 'theme'),
    'href' => "https://x.com/intent/post?url={$url}&amp;text={$title}",
    'icon' => 'x-social',
  ],
];
?>

<div>
  <p class="mb-2 font-bold text-gray-800">
    <?= __('Share this article', 'theme'); ?>
  </p>

  <div class="flex flex-wrap gap-1.5">
    <?php foreach ($buttons as $button) { ?>
      <a
        class="rounded border border-gray-300 p-2 text-gray-600 hover:border-primary-600 hover:bg-primary-600 hover:text-white"
        href="<?= $button['href']; ?>"
        title="<?= $button['title']; ?>"
      >
        <?= component('svg/' . $button['icon'], [ 'class' => 'w-5 h-5' ]); ?>
      </a>
    <?php } ?>
  </div>
</div>
