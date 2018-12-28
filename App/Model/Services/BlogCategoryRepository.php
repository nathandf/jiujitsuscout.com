<?php

namespace Model\Services;

class BlogCategoryRepository extends Repository
{

    public function create( $blog_id, $name, $image_id, $title = null, $description = null )
    {
        $mapper = $this->getMapper();
        $blogCategory = $mapper->build( $this->entityName );
        $blogCategory->blog_id = $blog_id;
        $blogCategory->name = $name;
        $blogCategory->url = $this->createURLFromName( $name );
        $blogCategory->image_id = $image_id;
        $blogCategory->title = $title;
        $blogCategory->description = $description;
        $mapper->create( $blogCategory );

        return $blogCategory;
    }

    public function getAllByBlogID( $blog_id )
    {
        $mapper = $this->getMapper();
        $blogCategorys = $mapper->mapAllFromBlogID( $blog_id );

        return $blogCategorys;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $blogCategory = $mapper->build( $this->entityName );
        $mapper->mapFromID( $blogCategory, $id );

        return $blogCategory;
    }

    public function getByBlogIDAndURL( $blog_id, $url )
    {
        $mapper = $this->getMapper();
        $blogCategory = $mapper->build( $this->entityName );
        $mapper->mapFromBlogIDAndURL( $blogCategory, $blog_id, $url );

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
