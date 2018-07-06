<?php

namespace Controllers\JjsAdmin;

use \Core\Controller;

class Leads extends Controller
{
    public function indexAction()
    {
        $this->view->render( "App/Views/jjs-admin/leads/leads.php" );
    }
}
