<?php

namespace Controllers\JjsAdmin;

use Core\Controller;

class Blog extends Controller
{

    public function before()
    {
        if ( !isset( $this->params[ "id" ] ) ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }
        // Loading services
		$userAuth = $this->load( "user-authenticator" );
		$userRepo = $this->load( "user-repository" );
		// If user not validated with session or cookie, send them to sign in
		if ( !$userAuth->userValidate( [ "jjs-admin" ] ) ) {
			$this->view->redirect( "jjs-admin/sign-in" );
		}
		// User is logged in. Get the user object from the UserAuthenticator service
		$this->user = $userAuth->getUser();
    }

    public function indexAction()
    {
        $blogRepo = $this->load( "blog-repository" );

        $blog = $blogRepo->getByID( $this->params[ "id" ] );

        vdumpd( $blog );
    }

}
