<?php

namespace Controllers\JjsAdmin\Blog;

use Core\Controller;

class Article extends Controller
{
    public $blog;
    public $article;

    public function before()
    {
        if ( isset( $this->params[ "blogid" ] ) == false || isset( $this->params[ "articleid" ] ) == false ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }

        $blogRepo = $this->load( "blog-repository" );
        $articleRepo = $this->load( "article-repository" );

        $this->blog = $blogRepo->getByID( $this->params[ "blogid" ] );

        $this->article = $articleRepo->getByIDAndBlogID(
            $this->params[ "articleid" ],
            $this->params[ "blogid" ]
        );

        if ( is_null( $this->article->id ) ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }

        $this->view->assign( "blog", $this->blog );
        $this->view->assign( "article", $this->article );

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
        foreach ( $this->params as $key => $param ) {
            echo $key . ": " . $param . "<br>";
        }
    }

}
