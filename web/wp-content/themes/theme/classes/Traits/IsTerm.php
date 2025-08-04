<?php

namespace Theme\Traits;

trait IsTerm
{
  private $id;
  private $wpTerm;

  public function __construct($id)
  {
    $this->id = $id;
    $this->wpTerm = get_term($id);
  }

  public function id()
  {
    return $this->id;
  }

  public function title()
  {
    return $this->wpTerm->name;
  }

  public function link()
  {
    return get_term_link($this->id);
  }
}
