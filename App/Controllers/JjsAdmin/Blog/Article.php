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
        $blogNavigationElementRepo = $this->load( "blog-navigation-element-repository" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );
        $imageRepo = $this->load( "image-repository" );

        $this->blog = $blogRepo->getByID( $this->params[ "blogid" ] );

        $this->article = $articleRepo->getByIDAndBlogID(
            $this->params[ "articleid" ],
            $this->params[ "blogid" ]
        );

        if ( is_null( $this->article->id ) ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }

        $blogNavigationElements = $blogNavigationElementRepo->getAllByBlogID( $this->blog->id );

        // Replace tags with html
        $this->article->body = $HTMLTagConverter->replaceTags( $this->article->body );

        // Get image for article
        $this->article->image = $imageRepo->getByID( $this->article->primary_image_id );

        $this->view->assign( "blog", $this->blog );
        $this->view->assign( "article", $this->article );
        $this->view->assign( "blogNavigationElements", $blogNavigationElements );

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
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $articleRepo = $this->load( "article-repository" );
        $blogCategoryRepo = $this->load( "blog-category-repository" );
        $articleBlogCategoryRepo = $this->load( "article-blog-category-repository" );
        $imageRepo = $this->load( "image-repository" );
        $imageManager = $this->load( "image-manager" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );

        $blogCategories = $blogCategoryRepo->getAllByBlogID( $this->blog->id );
        $articleBlogCategories = $articleBlogCategoryRepo->getAllByArticleID( $this->article->id );
        $selectedBlogCategoryIDs = [];

        foreach ( $articleBlogCategories as $articleBlogCategory ) {
            $selectedBlogCategoryIDs[] = $articleBlogCategory->blog_category_id;
        }

        foreach ( $blogCategories as $blogCategory ) {
            $blogCategory->selected = false;
            if ( in_array( $blogCategory->id, $selectedBlogCategoryIDs ) ) {
                $blogCategory->selected = true;
            }
        }

        $image_ids = [];
        $images = $imageRepo->getAllByBusinessID( 0 );

        foreach ( $images as $image ) {
            $image_ids[] = $image->id;
        }

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "token" => [
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
            "update_article"
            )
        ) {
            $status = "draft";
            if ( $input->issetField( "publish" ) ) {
                $status = "published";
            } elseif ( $input->issetField( "unpublish" ) ) {
                $status = "unpublished";
            }

            $body = $HTMLTagConverter->replaceHTML( $input->get( "body", null ) );

            $articleRepo->updatePrimaryImageIDByID( $this->article->id, $input->get( "primary_image_id" ) );
            $articleRepo->updateSlugByID( $this->article->id, $input->get( "slug" ) );
            $articleRepo->updateTitleByID( $this->article->id, $input->get( "title" ) );
            $articleRepo->updateMetaTitleByID( $this->article->id, $input->get( "meta_title" ) );
            $articleRepo->updateMetaDescriptionByID( $this->article->id, $input->get( "meta_description" ) );
            $articleRepo->updateBodyByID( $this->article->id, filter_var( $body, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES ) );
            $articleRepo->updateUpdatedAtByID( $this->article->id, time() );
            $articleRepo->updateStatusByID( $this->article->id, $status );

            // TODO Fix this. This is really bad
            $articleBlogCategoryRepo->removeByArticleID( $this->article->id );

            $blog_category_ids = $input->get( "blog_category_ids" );
            if ( $blog_category_ids != "" ) {
                foreach ( $blog_category_ids as $blog_category_id ) {
                    $articleBlogCategoryRepo->create( $this->article->id, $blog_category_id );
                }
            }
            $this->view->redirect( "jjs-admin/blog/" . $this->blog->id . "/article/" . $this->article->id . "/" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "blogCategories", $blogCategories );
        $this->view->assign( "images", $images );
        $this->view->assign( "root", HOME );

        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "jjs-admin/blog/article/create-article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog/Article.php" );
    }

    public function previewAction()
    {
        $articleBlogCategoryRepo = $this->load( "article-blog-category-repository" );
        $blogCategoryRepo = $this->load( "blog-category-repository" );
        $imageRepo = $this->load( "image-repository" );

        $blogCategories = [];
        $articleBlogCategories = $articleBlogCategoryRepo->getAllByArticleID( $this->article->id );
        foreach ( $articleBlogCategories as $articleBlogCategory ) {
            $blogCategories[] = $blogCategoryRepo->getByID( $articleBlogCategory->blog_category_id );
        }

        $image = $imageRepo->getByID( $this->article->primary_image_id );

        $this->view->assign( "blogCategories", $blogCategories );
        $this->view->assign( "image", $image );

        $this->view->setTemplate( "article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog/Article.php" );
    }

}
