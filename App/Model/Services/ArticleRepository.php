<?php

namespace Model\Services;

class ArticleRepository extends Service
{

    public function create( $blog_id, $title, $slug, $meta_title, $meta_description, $publisher, $author, $body, $status, $created_at = null, $updated_at = null )
    {
        $article = new \Model\Article();
        $article->blog_id = $blog_id;
        $article->title = $title;
        $article->slug = $slug;
        $article->meta_title = $meta_title;
        $article->meta_description = $meta_description;
        $article->publisher = $publisher;
        $article->author = $author;
        $article->body = $body;
        $article->status = $status;

        $now = time();
        $article->created_at = $now;
        $article->updated_at = $now;

        if ( !is_null( $created_at ) ) {
            $article->created_at = $created_at;
        }

        if ( !is_null( $updated_at ) ) {
            $article->updated_at = $updated_at;
        }

        $articleMapper = new \Model\Mappers\ArticleMapper( $this->container );
        $articleMapper->create( $article );

        return $article;
    }

    public function getAllByBlogID( $blog_id )
    {
        $articleMapper = new \Model\Mappers\ArticleMapper( $this->container );
        $articles = $articleMapper->mapAllFromBlogID( $blog_id );

        return $articles;
    }

    public function getByID( $id )
    {
        $article = new \Model\Article();
        $articleMapper = new \Model\Mappers\ArticleMapper( $this->container );
        $articleMapper->mapFromID( $article, $id );

        return $article;
    }

    public function getByIDAndBlogID( $id, $blog_id )
    {
        $article = new \Model\Article();
        $articleMapper = new \Model\Mappers\ArticleMapper( $this->container );
        $articleMapper->mapFromIDAndBlogID( $article, $id, $blog_id );

        return $article;
    }

    public function getBySlug( $slug )
    {
        $article = new \Model\Article();
        $articleMapper = new \Model\Mappers\ArticleMapper( $this->container );
        $articleMapper->mapFromSlug( $article, $slug );

        return $article;
    }
}
