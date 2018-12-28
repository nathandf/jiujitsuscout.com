<?php

namespace Model\Services;

class BlogRepository extends Repository
{

    public function create( $name, $url, $title, $description, $image_id )
    {
        $mapper = $this->getMapper();
        $blog = $mapper->build( $this->entityName );
        $blog->name = $name;
        $url = preg_replace( "/[ _]/", "-", strtolower( $url ) );
        $blog->url = preg_replace( "/[-+]/", "-", strtolower( $url ) );
        $blog->title = $title;
        $blog->description = $description;
        $blog->image_id = $image_id;
        $mapper->create( $blog );

        return $blog;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $blogs = $mapper->mapAll();
        return $blogs;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $blog = $mapper->build( $this->entityName );
        $mapper->mapFromID( $blog, $id );

        return $blog;
    }

    public function getByURL( $url )
    {
        $mapper = $this->getMapper();
        $blog = $mapper->build( $this->entityName );
        $mapper->mapFromURL( $blog, $url );

        return $blog;
    }
}
