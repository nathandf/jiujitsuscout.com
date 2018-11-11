<?php

namespace Model\Services;

class BlogRepository extends Service
{

    public function create( $name, $url, $title, $description, $image_id )
    {
        $blog = new \Model\Blog();
        $blog->name = $name;
        $url = preg_replace( "/[ _]/", "-", strtolower( $url ) );
        $blog->url = preg_replace( "/[-+]/", "-", strtolower( $url ) );
        $blog->title = $title;
        $blog->description = $description;
        $blog->image_id = $image_id;
        $blogMapper = new \Model\Mappers\BlogMapper( $this->container );
        $blogMapper->create( $blog );

        return $blog;
    }

    public function getAll()
    {
        $blogMapper = new \Model\Mappers\BlogMapper( $this->container );
        $blogs = $blogMapper->mapAll();
        return $blogs;
    }

    public function getByID( $id )
    {
        $blog = new \Model\Blog();
        $blogMapper = new \Model\Mappers\BlogMapper( $this->container );
        $blogMapper->mapFromID( $blog, $id );

        return $blog;
    }

    public function getByURL( $url )
    {
        $blog = new \Model\Blog();
        $blogMapper = new \Model\Mappers\BlogMapper( $this->container );
        $blogMapper->mapFromURL( $blog, $url );

        return $blog;
    }
}
