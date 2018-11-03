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
        $blogCategoryRepo = $this->load( "blog-category-repository" );
        $articleBlogCategoryRepo = $this->load( "article-blog-category-repository" );
        $imageRepo = $this->load( "image-repository" );
        $imageManager = $this->load( "image-manager" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );

        $blogCategories = $blogCategoryRepo->getAllByBlogID( $this->blog->id );

        $image_ids = [];
        $images = $imageRepo->getAllByBusinessID( 0 );

        foreach ( $images as $image ) {
            $image_ids[] = $image->id;
        }

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
                "blog_category_ids" => [
                    "name" => "Category",
                    "is_array" => true
                ],
                "body" => [
                    "name" => "Article Body",
                    "required" => true,
                    "min" => 1
                ],
                "primary_image_id" => [
                    "name" => "Primary Image",
                    "required" => true,
                    "in_array" => $image_ids
                ]
            ],
            "create_article"
            )
        ) {
            $status = "draft";
            if ( $input->issetField( "publish" ) ) {
                $status = "published";
            }

            $body = $HTMLTagConverter->replaceHTML( $input->get( "body", null ) );

            $article = $articleRepo->create(
                $this->blog->id,
                $input->get( "title" ),
                $input->get( "slug" ),
                $input->get( "meta_title" ),
                $input->get( "meta_description" ),
                "JiuJitsuScout LLC",
                $this->user->getFullName(),
                filter_var( $body, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES ),
                $status
            );

            $articleRepo->updatePrimaryImageIDByID( $article->id, $input->get( "primary_image_id" ) );

            $blog_category_ids = $input->get( "blog_category_ids" );
            if ( $blog_category_ids != "" ) {
                foreach ( $blog_category_ids as $id ) {
                    $articleBlogCategoryRepo->create( $article->id, $id );
                }
            }

            $this->view->redirect( "jjs-admin/blog/" . $this->params[ "id" ] . "/article/" . $article->id . "/" );
        }

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "create_article" ) ) {
            $inputs[ "create_article" ][ "chosen_image" ] = $input->get( "chosen_image" );
            $inputs[ "create_article" ][ "title" ] = $input->get( "title" );
            $inputs[ "create_article" ][ "slug" ] = $input->get( "slug" );
            $inputs[ "create_article" ][ "meta_title" ] = $input->get( "meta_title" );
			$inputs[ "create_article" ][ "meta_description" ] = $input->get( "meta_description" );
            $inputs[ "create_article" ][ "body" ] = $input->get( "body" );
        }

        $this->view->assign( "inputs", $inputs );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "blogCategories", $blogCategories );
        $this->view->assign( "images", $images );
        $this->view->assign( "root", "./../../../../../" );

        $this->view->setTemplate( "jjs-admin/blog/create-article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

    public function imagesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $imageManager = $this->load( "image-manager" );
        $config = $this->load( "config" );

        if ( $input->exists() && $input->issetField( "upload_image" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "upload_image" => [
                        "required" => true
                    ]

                ],

                "upload_image" /* error index */
            ) )
        {

            $this->view->redirect( "jjs-admin/blog/images" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/logo.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

    public function menuAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $blogCategoryRepo = $this->load( "blog-category-repository" );
        $blogNavigationElementRepo = $this->load( "blog-navigation-element-repository" );

        $blogCategories = $blogCategoryRepo->getAllByBlogID( $this->blog->id );
        $blogNavigationElements = $blogNavigationElementRepo->getAllByBlogID( $this->blog->id );

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "blog_category_id" => [
                    "numeric" => true
                ],
                "url" => [
                    "required" => true,
                    "min" => 1
                ],
                "text" => [
                    "required" => true,
                    "min" => 1,
                    "max" => 25
                ],
            ],
            "new_navigation_element"
            )
        ) {

        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "jjs-admin/blog/menu.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

    public function categoriesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $blogCategoryRepo = $this->load( "blog-category-repository" );

        $blogCategories = $blogCategoryRepo->getAllByBlogID( $this->blog->id );
        $blogCategoryURLs = [];

        foreach ( $blogCategories as $category ) {
            $blogCategoryURLs[] = $category->url;
        }

        if ( $input->exists() && $input->issetField( "new-category" ) && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "name" => [
                    "required" => true,
                    "name" => "Category Name"
                ]
            ],
            "new_category"
            )
        ) {
            $name = $input->get( "name" );
            if ( !in_array( $blogCategoryRepo->createURLFromName( $name ), $blogCategoryURLs ) ) {
                $blogCategoryRepo->create( $this->blog->id, $name );
                $this->view->redirect( "jjs-admin/blog/" . $this->blog->id . "/categories" );
            }

            $inputValidator->addError( "new_category", "Category already exists" );
        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "blogCategories", $blogCategories );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "jjs-admin/blog/categories.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog.php" );
    }

    public function uploadImageAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $imageRepo = $this->load( "image-repository" );
        $imageManager = $this->load( "image-manager" );
    }

}
