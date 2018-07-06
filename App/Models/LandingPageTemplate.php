<?php

namespace Models;

use Contracts\EntityInterface;

class LandingPageTemplate implements EntityInterface
{

  public $id;
  public $name;
  public $template_filename;

}
