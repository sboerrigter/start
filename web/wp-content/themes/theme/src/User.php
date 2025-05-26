<?php

namespace Theme;

class User
{
  private $id;
  private $wpUser;

  public function __construct($id)
  {
    $this->id = $id;
    $this->wpUser = get_user_by('id', $id);
  }

  public function id()
  {
    return $this->id;
  }

  public function name()
  {
    return $this->wpUser->display_name;
  }

  public function link()
  {
    return get_author_posts_url($this->id);
  }
}
