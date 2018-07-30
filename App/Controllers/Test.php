<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function indexAction()
    {

    }

    public function sequenceManagerAction()
    {
        $sequenceManager = $this->load( "sequence-dispatcher" );
        $sequenceManager->dispatch();
    }
}
