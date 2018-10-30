<?php

namespace Controllers;

use \Core\Controller;

class Blog extends Controller
{
	private $taxonimies = [ "category", "tag", "sub-category" ];
	public $blog;

	public function before()
	{
		$this->requireParam( "blogurl" );
        $blogRepo = $this->load( "blog-repository" );
        $articleRepo = $this->load( "article-repository" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );

        $this->blog = $blogRepo->getByURL( $this->params[ "blogurl" ] );
        $this->view->assign( "blog", $this->blog );
	}

	public function indexAction()
	{
		$articleRepo = $this->load( "article-repository" );

		$allArticles = $articleRepo->getAllByBlogID( $this->blog->id );
		$articles = [];
		foreach ( $allArticles as $_article ) {
			if ( $_article->status == "published" ) {
				$articles[] = $_article;
			}
		}

        $this->view->setTemplate( "blog/home.tpl" );

		$this->view->assign( "articles", $articles );
        $this->view->render( "App/Views/Blog/Article.php" );
	}

	public function articleAction()
	{
		$articleRepo = $this->load( "article-repository" );
		$HTMLTagConverter = $this->load( "html-tag-converter" );
		$articleBlogCategoryRepo = $this->load( "article-blog-category-repository" );
        $blogCategoryRepo = $this->load( "blog-category-repository" );
        $imageRepo = $this->load( "image-repository" );

		$article = $articleRepo->getBySlugAndBlogID( $this->params[ "article" ], $this->blog->id );

		if ( is_null( $article->id ) || $article->status != "published" ) {
			$this->view->render404();
		}

        $blogCategories = [];
        $articleBlogCategories = $articleBlogCategoryRepo->getAllByArticleID( $article->id );
        foreach ( $articleBlogCategories as $articleBlogCategory ) {
            $blogCategories[] = $blogCategoryRepo->getByID( $articleBlogCategory->blog_category_id );
        }

        $image = $imageRepo->getByID( $article->primary_image_id );

		// Replace tags with html
        $article->body = $HTMLTagConverter->replaceTags( $article->body );

		$this->view->assign( "article", $article );
        $this->view->assign( "blogCategories", $blogCategories );
        $this->view->assign( "image", $image );

        $this->view->setTemplate( "article.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Blog/Article.php" );
	}

	public function taxonomyAction()
	{
		if ( !in_array( $this->params[ "taxonomy" ], $this->taxonimies ) ) {
			$this->view->render404();
		}

		foreach ( $this->params as $key => $param ) {
			echo( $key . ": " . $param . "<br>" );
		}
	}

	public function taxonAction()
	{
		foreach ( $this->params as $key => $param ) {
			echo( $key . ": " . $param . "<br>" );
		}
	}

	public function dateAction()
	{
		foreach ( $this->params as $key => $param ) {
			echo( $key . ": " . $param . "<br>" );
		}
	}
}
