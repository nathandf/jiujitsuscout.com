<?php

namespace Model\Mappers;

class BlogCategoryMapper extends DataMapper
{

    public function create( \Model\BlogCategory $blogCategory )
    {
        $id = $this->insert(
            "blog_category",
            [ "blog_id", "name", "url", "title", "description", "image_id" ],
            [ $blogCategory->blog_id, $blogCategory->name, $blogCategory->url, $blogCategory->title, $blogCategory->description, $blogCategory->image_id ]
        );

        $blogCategory->id = $id;

        return $blogCategory;
    }

    public function mapAllFromBlogID( $blog_id )
    {
        
        $blogCategories = [];
        $sql = $this->DB->prepare( 'SELECT * FROM blog_category WHERE blog_id = :blog_id' );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $blogCategory = $this->entityFactory->build( "BlogCategory" );
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

    public function mapFromBlogIDAndURL( \Model\BlogCategory $blogCategory, $blog_id, $url )
    {
        $sql = $this->DB->prepare( "SELECT * FROM blog_category WHERE blog_id = :blog_id AND url = :url" );
        $sql->bindParam( ":blog_id", $blog_id );
        $sql->bindParam( ":url", $url );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $blogCategory, $resp );
        return $blogCategory;
    }
}
