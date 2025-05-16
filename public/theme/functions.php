<?php

namespace Theme;

// Require functions
require_once 'functions/component.php';
require_once 'functions/debug.php';

// Initialize classes
Admin::init();
Assets::init();
Cleanup::init();
Content::init();
Editor::init();
Image::init();
Media::init();
Menu::init();
Oembed::init();
Security::init();
Translation::init();

Plugins\Acf\GeneralContent::init();

PostTypes\Page::init();
PostTypes\Post::init();
