<?php

namespace Controllers\Callbacks;

use \Core\Controller;

class Facebook extends Controller
{

    public function loginAction()
    {
        $facebookLogin = $this->load( "facebook-login" );
    }

    public function indexAction()
    {
        $facebookLogin = $this->load( "facebook-login" );
    }

}
