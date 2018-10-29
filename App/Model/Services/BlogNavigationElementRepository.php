<?php

namespace Model\Services;

class BlogNavigationElementRepository extends Service
{

    public function create( $blog_id, $blog_category_id, $url, $text )
    {
        $blogNavigationElement = new \Model\BlogNavigationElement();
        $blogNavigationElement->blog_id = $blog_id;
        $blogNavigationElement->blog_category_id = $blog_category_id;
        $blogNavigationElement->url = $url;
        $blogNavigationElement->text = $text;

        $blogNavigationElementMapper = new \Model\Mappers\BlogNavigationElementMapper( $this->container );
        $blogNavigationElementMapper->create( $blogNavigationElement );

        return $blogNavigationElement;
    }

    public function getAllByBlogID( $blog_id )
    {
        $blogNavigationElementMapper = new \Model\Mappers\BlogNavigationElementMapper( $this->container );
        $blogNavigationElements = $blogNavigationElementMapper->mapAllFromBlogID( $blog_id );

        return $blogNavigationElements;
    }

    public function getByID( $id )
    {
        $blogNavigationElement = new \Model\BlogNavigationElement();
        $blogNavigationElementMapper = new \Model\Mappers\BlogNavigationElementMapper( $this->container );
        $blogNavigationElementMapper->mapFromID( $blogNavigationElement, $id );

        return $blogNavigationElement;
    }
}
