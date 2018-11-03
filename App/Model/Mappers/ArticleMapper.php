<?php

namespace Model\Mappers;

class ArticleMapper extends DataMapper
{

    public function create( \Model\Article $article )
    {
        $id = $this->insert(
            "article",
            [ "blog_id", "title", "slug", "meta_title", "meta_description", "publisher", "author", "body", "status", "created_at", "updated_at", "primary_image_id" ],
            [ $article->blog_id, $article->title, $article->slug, $article->meta_title, $article->meta_description, $article->publisher, $article->author, $article->body, $article->status, $article->created_at, $article->updated_at, $article->primary_image_id ]
        );

        $article->id = $id;

        return $article;
    }

    public function updatePrimaryImageIDByID( $id, $primary_image_id )
    {
        $this->update( "article", "primary_image_id", $primary_image_id, "id", $id );
    }

    public function mapAllFromBlogID( $blog_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $articles = [];
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

    public function mapFromID( \Model\Article $article, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM article WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $article, $resp );
        return $article;
    }

    public function mapFromIDAndBlogID( \Model\Article $article, $id, $blog_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM article WHERE id = :id AND blog_id = :blog_id" );
        $sql->bindParam( ":id", $id );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $article, $resp );
        return $article;
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

    public function mapFromSlugAndBlogID( \Model\Article $article, $slug, $blog_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM article WHERE slug = :slug AND blog_id = :blog_id" );
        $sql->bindParam( ":slug", $slug );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $article, $resp );
        return $article;
    }

}
