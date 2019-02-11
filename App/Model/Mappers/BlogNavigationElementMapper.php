<?php

namespace Model\Mappers;

class BlogNavigationElementMapper extends DataMapper
{

    public function create( \Model\BlogNavigationElement $blogNavigationElement )
    {
        $id = $this->insert(
            "blog_navigation_element",
            [ "blog_id", "blog_category_id", "url", "text" ],
            [ $blogNavigationElement->blog_id, $blogNavigationElement->blog_category_id, $blogNavigationElement->url, $blogNavigationElement->text ]
        );

        $blogNavigationElement->id = $id;

        return $blogNavigationElement;
    }

    public function mapAllFromBlogID( $blog_id )
    {
        
        $blogNavigationElements = [];
        $sql = $this->DB->prepare( 'SELECT * FROM blog_navigation_element WHERE blog_id = :blog_id' );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $blogNavigationElement = $this->entityFactory->build( "BlogNavigationElement" );
            $this->populate( $blogNavigationElement, $resp );
            $blogNavigationElements[] = $blogNavigationElement;
        }

        return $blogNavigationElements;
    }

    public function mapFromID( \Model\BlogNavigationElement $blogNavigationElement, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM blog_navigation_element WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $blogNavigationElement, $resp );
        return $blogNavigationElement;
    }
}
