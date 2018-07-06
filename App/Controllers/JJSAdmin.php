<?php

namespace Controllers;

use \Core\Controller;

class JJSAdmin extends Controller
{

    public function indexAction()
    {
        $this->view->setTemplate( "jjs-admin/home.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function requestAccessAction()
    {
        $this->view->setTemplate( "jjs-admin/request-access.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function usersAction()
    {
        $this->view->setTemplate( "jjs-admin/users.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function signInAction()
    {
        $this->view->setTemplate( "jjs-admin/jjs-sign-in.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function partnerAction()
    {
        $this->view->setTemplate( "jjs-admin/business.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function partnersAction()
    {
        $this->view->setTemplate( "jjs-admin/businesses.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function leadsAction()
    {
        $this->view->setTemplate( "jjs-admin/leads.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

    public function callCenterAction()
    {
        $this->view->setTemplate( "jjs-admin/call-center-home.tpl" );
        $this->view->render( "App/Views/jjs-admin.php" );
    }

}
