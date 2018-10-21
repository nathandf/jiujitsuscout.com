<?php

namespace Controllers\JjsAdmin;

use Core\Controller;

class Blog extends Controller
{
    public $blog;
    public $user;

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
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $articleRepo = $this->load( "article-repository" );

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "name" => "",
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "title" => [
                    "name" => "Article Title",
                    "required" => true,
                    "min" => 1,
                    "max" => 255
                ],
                "slug" => [
                    "name" => "Slug",
                    "required" => true,
                    "min" => 1,
                    "max" => 255
                ],
                "meta_title" => [
                    "name" => "Meta Title",
                    "required" => true,
                    "min" => 1,
                    "max" => 255
                ],
                "meta_description" => [
                    "name" => "Meta Description",
                    "required" => true,
                    "min" => 1,
                    "max" => 512
                ],
                "body" => [
                    "name" => "Article Body",
                    "required" => true,
                    "min" => 1
                ],
            ],
            "create_article"
            )
        ) {

            $status = "draft";
            if ( $input->issetField( "publish" ) ) {
                $status = "published";
            }

            $article = $articleRepo->create(
                $this->blog->id,
                $input->get( "title" ),
                $input->get( "slug" ),
                $input->get( "meta_title" ),
                $input->get( "meta_description" ),
                "JiuJitsuScout LLC",
                $this->user->getFullName(),
                $input->get( "body" ),
                $status
            );
            $this->view->redirect( "jjs-admin/blog/" . $this->params[ "id" ] . "/article/" . $article->id . "/" );
        }

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "create_article" ) ) {
            $inputs[ "create_article" ][ "title" ] = $input->get( "title" );
            $inputs[ "create_article" ][ "slug" ] = $input->get( "slug" );
            $inputs[ "create_article" ][ "meta_title" ] = $input->get( "meta_title" );
			$inputs[ "create_article" ][ "meta_description" ] = $input->get( "meta_description" );
            $inputs[ "create_article" ][ "body" ] = $input->get( "body" );
        }

        $this->view->assign( "inputs", $inputs );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "jjs-admin/blog/create-article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

}
