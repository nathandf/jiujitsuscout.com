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
        $HTMLTagConverter = $this->load( "html-tag-converter" );

        $this->blog = $blogRepo->getByID( $this->params[ "blogid" ] );

        $this->article = $articleRepo->getByIDAndBlogID(
            $this->params[ "articleid" ],
            $this->params[ "blogid" ]
        );

        if ( is_null( $this->article->id ) ) {
            $this->view->redirect( "jjs-admin/blogs" );
        }

        // Replace tags with html
        $this->article->body = $HTMLTagConverter->replaceTags( $this->article->body );

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
