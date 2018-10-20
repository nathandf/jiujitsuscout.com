<?php

namespace Model\Mappers;

class BlogMapper extends DataMapper
{

    public function create( \Model\Blog $blog )
    {
        $id = $this->insert(
            "blog",
            [ "name", "url" ],
            [ $blog->name, $blog->url ]
        );

        $blog->id = $id;

        return $blog;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $blogs = [];
        $sql = $this->DB->prepare( 'SELECT * FROM blog' );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $blog = $entityFactory->build( "Blog" );
            $this->populate( $blog, $resp );
            $blogs[] = $blog;
        }

        return $blogs;
    }

    public function mapFromID( \Model\Blog $blog, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM blog WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $blog, $resp );
        return $blog;
    }

    public function mapFromURL( \Model\Blog $blog, $url )
    {
        $sql = $this->DB->prepare( "SELECT * FROM blog WHERE url = :url" );
        $sql->bindParam( ":url", $url );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $blog, $resp );
        return $blog;
    }

}
