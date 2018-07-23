<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function indexAction()
    {
        $this->view->setTemplate( "braintree-test.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function sequenceMangerAction()
    {
        $sequenceManager = $this->load( "sequence-manager" );
        $sequenceManager->dispatch();
    }
}
