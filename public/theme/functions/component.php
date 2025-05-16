<?php
// Get template component from components folder with optional args
function component(string $name, array $args = [])
{
  $file = dirname(__FILE__, 2) . '/components/' . $name . '.phtml';

  extract($args);
  ob_start();
  require $file;

  return ob_get_clean();
}
