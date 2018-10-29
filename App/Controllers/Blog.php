<?php

namespace Controllers;

use \Core\Controller;

class Blog extends Controller
{
	private $taxonimies = [ "category", "tag", "sub-category" ];
	public $blog;

	public function before()
	{
        $blogRepo = $this->load( "blog-repository" );
        $articleRepo = $this->load( "article-repository" );
        $HTMLTagConverter = $this->load( "html-tag-converter" );

        $this->blog = $blogRepo->getByURL( $this->params[ "blogurl" ] );
        $this->view->assign( "blog", $this->blog );
	}

	public function indexAction()
	{
		$articleRepo = $this->load( "article-repository" );
		$HTMLTagConverter = $this->load( "html-tag-converter" );

		$allArticles = $articleRepo->getAllByBlogID( $this->blog->id );
		$articles = [];
		foreach ( $allArticles as $_article ) {
			if ( $_article->status == "published" ) {
				$articles[] = $_article;
			}
		}
		$article = $articleRepo->getBySlugAndBlogID( $this->params[ "article" ], $this->blog->id );

		$this->view->setTemplate( "article.tpl" );

        if ( is_null( $article->id ) ) {
            $this->view->setTemplate( "blog/home.tpl" );
        }

        // Replace tags with html
        $article->body = $HTMLTagConverter->replaceTags( $article->body );

		$this->view->assign( "article", $article );
		$this->view->assign( "articles", $articles );
        $this->view->render( "App/Views/Blog/Article.php" );
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

	public function dateAction()
	{
		foreach ( $this->params as $key => $param ) {
			echo( $key . ": " . $param . "<br>" );
		}
	}
}
