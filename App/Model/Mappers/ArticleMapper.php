<?php

namespace Model\Mappers;

class ArticleMapper extends DataMapper
{

    public function create( \Model\Article $article )
    {
        $now = time();
        $id = $this->insert(
            "article",
            [ "blog_id", "title", "slug", "meta_title", "meta_description", "publisher", "author", "body", "created_at", "updated_at" ]
            [ $article->blog_id, $article->title, $article->slug, $article->meta_title, $article->meta_description, $article->publisher, $article->author, $article->body, $now, $now ]
        );

        $article->id = $id;

        return $article;
    }

    public function mapAllFromBlogID( $blog_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $article = [];
        $sql = $this->DB->prepare( 'SELECT * FROM article WHERE blog_id = :blog_id' );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $article = $entityFactory->build( "Article" );
            $this->populate( $article, $resp );
            $articles[] = $article;
        }

        return $articles;
    }

    public function mapFromSlug( \Model\Article $article, $slug )
    {
        $sql = $this->DB->prepare( "SELECT * FROM article WHERE slug = :slug" );
        $sql->bindParam( ":slug", $slug );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $article, $resp );
        return $article;
    }

}
