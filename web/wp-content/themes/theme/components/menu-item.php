<div
  class="
    menu-item group relative
    <?= !isset($isChild) ?
      'max-lg:border-t max-lg:last:border-b border-white/25 font-semibold' :
      'font-normal'
    ?>
    <?= $item->isCurrent || $item->isParent ? 'menu-item-open' : ''?>
  "
>
  <div class="flex">
    <a
      class="
        flex gap-1 items-center max-lg:w-full no-underline text-white/75 hover:text-white/100
        <?= !isset($isChild) ?
          'p-3 lg:px-4 lg:py-3 lg:text-gray-800 lg:hover:text-primary-600' :
          'p-1 lg:px-4 lg:w-full'
        ?>
      "
      href="<?= $item->url; ?>"
      target="<?= $item->target; ?>"
    >
      <?= $item->title; ?>

      <?php if ($item->children) { ?>
        <?= component('svg/chevron-down', [
          'class' => 'hidden lg:block w-5 h-5',
        ]); ?>
      <?php } ?>
    </a>

    <?php if ($item->children) { ?>
    <div
      class="menu-item-toggle user-select-none flex h-12 w-12 -rotate-90 cursor-pointer items-center justify-center text-white/50 transition-all hover:text-white/100 lg:hidden"
    >
      <?= component('svg/chevron-down', ['class' => 'w-5 h-5']); ?>
    </div>
    <?php } ?>
  </div>

  <?php if ($item->children) { ?>
  <div
    class="menu-item-children hidden flex-col max-lg:mb-5 max-lg:ml-5 lg:absolute lg:left-0 lg:w-60 lg:rounded lg:bg-primary-900 lg:py-3 lg:group-last:right-0 lg:group-last:left-auto lg:group-hover:flex"
  >
    <?php foreach ($item->children as $item) { ?>
        <?= component('menu-item', [
          'item' => $item,
          'isChild' => true,
        ]); ?>
      <?php } ?>
  </div>
  <?php } ?>
</div>
