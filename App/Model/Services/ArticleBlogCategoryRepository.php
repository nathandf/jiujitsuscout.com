<?php

namespace Model\Services;

class ArticleBlogCategoryRepository extends Service
{

    public function create( $article_id, $blog_category_id )
    {
        $articleBlogCategory = new \Model\ArticleBlogCategory();
        $articleBlogCategory->article_id = $article_id;
        $articleBlogCategory->blog_category_id = $blog_category_id;
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategoryMapper->create( $articleBlogCategory );

        return $articleBlogCategory;
    }

    public function getAllByBlogCategoryID( $blog_category_id )
    {
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategories = $articleBlogCategoryMapper->mapAllFromBlogCategoryID( $blog_category_id );

        return $articleBlogCategories;
    }

    public function getAllByArticleID( $article_id )
    {
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategories = $articleBlogCategoryMapper->mapAllFromArticleID( $article_id );

        return $articleBlogCategories;
    }

    public function getByID( $id )
    {
        $articleBlogCategory = new \Model\ArticleBlogCategory();
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategoryMapper->mapFromID( $articleBlogCategory, $id );

        return $articleBlogCategory;
    }

    public function removeByID( $id )
    {
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategoryMapper->deleteByID( $id );
    }

    public function removeByBlogCategoryID( $blog_category_id )
    {
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategoryMapper->deleteByBlogCategoryID( $blog_category_id );
    }

    public function removeByArticleID( $article_id )
    {
        $articleBlogCategoryMapper = new \Model\Mappers\ArticleBlogCategoryMapper( $this->container );
        $articleBlogCategoryMapper->deleteByArticleID( $article_id );
    }

}
