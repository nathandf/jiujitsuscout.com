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
		$this->blog = $blogRepo->getByURL( $this->params[ "blogurl" ] );
	}

	public function indexAction()
	{
		echo "blog: " . $this->params[ "blogurl" ] . "<br>";
		if ( $this->params[ "article" ] == "" ) {
			echo "article: home page";
			return;
		}

		echo( "article: " . $this->params[ "article" ] );
		return;
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
