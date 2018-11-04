<?php

namespace Model\Mappers;

class BlogCategoryMapper extends DataMapper
{

    public function create( \Model\BlogCategory $blogCategory )
    {
        $id = $this->insert(
            "blog_category",
            [ "blog_id", "name", "url", "title", "description" ],
            [ $blogCategory->blog_id, $blogCategory->name, $blogCategory->url, $blogCategory->title, $blogCategory->description ]
        );

        $blogCategory->id = $id;

        return $blogCategory;
    }

    public function mapAllFromBlogID( $blog_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $blogCategories = [];
        $sql = $this->DB->prepare( 'SELECT * FROM blog_category WHERE blog_id = :blog_id' );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $blogCategory = $entityFactory->build( "BlogCategory" );
            $this->populate( $blogCategory, $resp );
            $blogCategories[] = $blogCategory;
        }

        return $blogCategories;
    }

    public function mapFromID( \Model\BlogCategory $blogCategory, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM blog_category WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $blogCategory, $resp );
        return $blogCategory;
    }
}
