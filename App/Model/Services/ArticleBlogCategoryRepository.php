<?php

namespace Model\Services;

class ArticleBlogCategoryRepository extends Repository
{

    public function create( $article_id, $blog_category_id )
    {
        $mapper = $this->getMapper();
        $articleBlogCategory = $mapper->build( $this->entityName );
        $articleBlogCategory->article_id = $article_id;
        $articleBlogCategory->blog_category_id = $blog_category_id;
        $mapper->create( $articleBlogCategory );

        return $articleBlogCategory;
    }

    public function getAllByBlogCategoryID( $blog_category_id )
    {
        $mapper = $this->getMapper();
        $articleBlogCategories = $mapper->mapAllFromBlogCategoryID( $blog_category_id );

        return $articleBlogCategories;
    }

    public function getAllByArticleID( $article_id )
    {
        $mapper = $this->getMapper();
        $articleBlogCategories = $mapper->mapAllFromArticleID( $article_id );

        return $articleBlogCategories;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $articleBlogCategory = $mapper->build( $this->entityName );
        $mapper->mapFromID( $articleBlogCategory, $id );

        return $articleBlogCategory;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

    public function removeByBlogCategoryID( $blog_category_id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByBlogCategoryID( $blog_category_id );
    }

    public function removeByArticleID( $article_id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByArticleID( $article_id );
    }

}
