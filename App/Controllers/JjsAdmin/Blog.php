<?php

namespace Controllers\JjsAdmin;

use Core\Controller;

class Blog extends Controller
{
    public $blog;

    public function before()
    {
        if ( !isset( $this->params[ "id" ] ) ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }

        $blogRepo = $this->load( "blog-repository" );

        $this->blog = $blogRepo->getByID( $this->params[ "id" ] );

        $this->view->assign( "blog", $this->blog );

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
        $articleRepo = $this->load( "article-repository" );
        $articles = $articleRepo->getAllByBlogID( $this->blog->id );

        $this->view->assign( "articles", $articles );

        $this->view->setTemplate( "jjs-admin/blog/home.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

    public function newArticleAction()
    {
        $this->view->setTemplate( "jjs-admin/blog/create-article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

}
