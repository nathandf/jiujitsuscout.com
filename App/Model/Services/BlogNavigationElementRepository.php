<?php

namespace Model\Services;

class BlogNavigationElementRepository extends Repository
{

    public function create( $blog_id, $url, $text, $blog_category_id = null )
    {
        $mapper = $this->getMapper();
        $blogNavigationElement = $mapper->build( $this->entityName );
        $blogNavigationElement->blog_id = $blog_id;
        $blogNavigationElement->url = $url;
        $blogNavigationElement->text = $text;
        $blogNavigationElement->blog_category_id = $blog_category_id;

        $mapper->create( $blogNavigationElement );

        return $blogNavigationElement;
    }

    public function getAllByBlogID( $blog_id )
    {
        $mapper = $this->getMapper();
        $blogNavigationElements = $mapper->mapAllFromBlogID( $blog_id );

        return $blogNavigationElements;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $blogNavigationElement = $mapper->build( $this->entityName );
        $mapper->mapFromID( $blogNavigationElement, $id );

        return $blogNavigationElement;
    }
}
