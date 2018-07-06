<?php

namespace Controllers\JjsAdmin;

use \Core\Controller;

class CallCenter extends Controller
{
    public function indexAction()
    {
        $this->view->render( "App/Views/jjs-admin/call-center/call-center.php" );
    }
}
