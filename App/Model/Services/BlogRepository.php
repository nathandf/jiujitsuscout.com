<?php

namespace Model\Services;

class BlogRepository extends Service
{

    public function create( $name, $url )
    {
        $blog = new \Model\Blog();
        $blog->name = $name;
        $url = preg_replace( "/[ _]/", "-", strtolower( $url ) );
        $blog->url = preg_replace( "/[-+]/", "-", strtolower( $url ) );
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
