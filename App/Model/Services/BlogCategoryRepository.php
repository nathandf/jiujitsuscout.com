<?php

namespace Model\Services;

class BlogCategoryRepository extends Service
{

    public function create( $blog_id, $name, $title = null, $description = null )
    {
        $blogCategory = new \Model\BlogCategory();
        $blogCategory->blog_id = $blog_id;
        $blogCategory->name = $name;
        $blogCategory->url = $this->createURLFromName( $name );
        $blogCategory->title = $title;
        $blogCategory->description = $description;
        $blogCategoryMapper = new \Model\Mappers\BlogCategoryMapper( $this->container );
        $blogCategoryMapper->create( $blogCategory );

        return $blogCategory;
    }

    public function getAllByBlogID( $blog_id )
    {
        $blogCategoryMapper = new \Model\Mappers\BlogCategoryMapper( $this->container );
        $blogCategorys = $blogCategoryMapper->mapAllFromBlogID( $blog_id );

        return $blogCategorys;
    }

    public function getByID( $id )
    {
        $blogCategory = new \Model\BlogCategory();
        $blogCategoryMapper = new \Model\Mappers\BlogCategoryMapper( $this->container );
        $blogCategoryMapper->mapFromID( $blogCategory, $id );

        return $blogCategory;
    }

    public function getByBlogIDAndURL( $blog_id, $url )
    {
        $blogCategory = new \Model\BlogCategory();
        $blogCategoryMapper = new \Model\Mappers\BlogCategoryMapper( $this->container );
        $blogCategoryMapper->mapFromBlogIDAndURL( $blogCategory, $blog_id, $url );

        return $blogCategory;
    }

    public function createURLFromName( $name )
    {
        $url = strtolower( trim( $name ) );
        $url = preg_replace( "/\s+/", "-", $url );
        $url = preg_replace( "/[^a-zA-Z0-9 _\-]*/", "", $url );

        return $url;
    }
}
