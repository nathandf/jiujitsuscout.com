<?php

namespace Controllers\JjsAdmin;

use \Core\Controller;

class Partners extends Controller
{
    public function indexAction()
    {
        $this->view->render( "App/Views/jjs-admin/partners/partners.php" );
    }

    public function partnerAction()
    {
        $this->view->render( "App/Views/jjs-admin/partners/partner.php" );
    }

    public function addPartnerAction()
    {
        $this->view->render( "App/Views/jjs-admin/partners/add-partner.php" );
    }
}
