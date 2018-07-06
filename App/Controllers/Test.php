<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{

  public function before()
  {

  }

  public function indexAction()
  {
    $sequenceManager = $this->load( "sequence-manager" );
    $sequenceManager->dispatch();
  }


}
