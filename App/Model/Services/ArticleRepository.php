<?php

namespace Model\Services;

class ArticleRepository extends Repository
{

    public function create( $blog_id, $title, $slug, $meta_title, $meta_description, $publisher, $author, $body, $status, $created_at = null, $updated_at = null, $primary_image_id = null )
    {
        $mapper = $this->getMapper();
        $article = $mapper->build( $this->entityName );
        $article->blog_id = $blog_id;
        $article->primary_image_id = $primary_image_id;
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

        $mapper->create( $article );

        return $article;
    }

    public function updatePrimaryImageIDByID( $id, $primary_image_id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePrimaryImageIDByID( $id, $primary_image_id );
    }

    public function getAllByBlogID( $blog_id )
    {
        $mapper = $this->getMapper();
        $articles = $mapper->mapAllFromBlogID( $blog_id );

        return $articles;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $article = $mapper->build( $this->entityName );
        $mapper->mapFromID( $article, $id );

        return $article;
    }

    public function getByIDAndBlogID( $id, $blog_id )
    {
        $mapper = $this->getMapper();
        $article = $mapper->build( $this->entityName );
        $mapper->mapFromIDAndBlogID( $article, $id, $blog_id );

        return $article;
    }

    public function getBySlug( $slug )
    {
        $mapper = $this->getMapper();
        $article = $mapper->build( $this->entityName );
        $mapper->mapFromSlug( $article, $slug );

        return $article;
    }

    public function getBySlugAndBlogID( $slug, $blog_id )
    {
        $mapper = $this->getMapper();
        $article = $mapper->build( $this->entityName );
        $mapper->mapFromSlugAndBlogID( $article, $slug, $blog_id );

        return $article;
    }

    public function updateByPrimaryImageIDByID( $id, $primary_image_id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePrimaryImageIDByID( $primary_image_id, $id );
    }

    public function updateTitleByID( $id, $title )
    {
        $mapper = $this->getMapper();
        $mapper->updateTitleByID( $id, $title );
    }

    public function updateSlugByID( $id, $slug )
    {
        $mapper = $this->getMapper();
        $mapper->updateSlugByID( $id, $slug );
    }

    public function updateMetaTitleByID( $id, $meta_title )
    {
        $mapper = $this->getMapper();
        $mapper->updateMetaTitleByID( $id, $meta_title );
    }

    public function updateMetaDescriptionByID( $id, $meta_description )
    {
        $mapper = $this->getMapper();
        $mapper->updateMetaDescriptionByID( $id, $meta_description );
    }

    public function updateStatusByID( $id, $status )
    {
        $mapper = $this->getMapper();
        $mapper->updateStatusByID( $id, $status );
    }

    public function updateBodyByID( $id, $body )
    {
        $mapper = $this->getMapper();
        $mapper->updateBodyByID( $id, $body );
    }

    public function updateUpdatedAtByID( $id, $updated_at )
    {
        $mapper = $this->getMapper();
        $mapper->updateUpdatedAtByID( $id, $updated_at );
    }
}
