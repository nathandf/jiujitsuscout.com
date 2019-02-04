<?php

namespace Model\Mappers;

class ArticleBlogCategoryMapper extends DataMapper
{

    public function create( \Model\ArticleBlogCategory $articleBlogCategory )
    {
        $id = $this->insert(
            "article_blog_category",
            [ "article_id", "blog_category_id" ],
            [ $articleBlogCategory->article_id, $articleBlogCategory->blog_category_id ]
        );

        $articleBlogCategory->id = $id;

        return $articleBlogCategory;
    }

    public function mapAllFromBlogCategoryID( $blog_category_id )
    {
        
        $articleBlogCategories = [];
        $sql = $this->DB->prepare( 'SELECT * FROM article_blog_category WHERE blog_category_id = :blog_category_id' );
        $sql->bindParam( ":blog_category_id", $blog_category_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $articleBlogCategory = $this->entityFactory->build( "ArticleBlogCategory" );
            $this->populate( $articleBlogCategory, $resp );
            $articleBlogCategories[] = $articleBlogCategory;
        }

        return $articleBlogCategories;
    }

    public function mapAllFromArticleID( $article_id )
    {
        
        $articleBlogCategories = [];
        $sql = $this->DB->prepare( 'SELECT * FROM article_blog_category WHERE article_id = :article_id' );
        $sql->bindParam( ":article_id", $article_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $articleBlogCategory = $this->entityFactory->build( "ArticleBlogCategory" );
            $this->populate( $articleBlogCategory, $resp );
            $articleBlogCategories[] = $articleBlogCategory;
        }

        return $articleBlogCategories;
    }

    public function mapFromID( \Model\ArticleBlogCategory $articleBlogCategory, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM article_blog_category WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $articleBlogCategory, $resp );
        return $articleBlogCategory;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM article_blog_category WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function deleteByArticleID( $article_id )
    {
        $sql = $this->DB->prepare( "DELETE FROM article_blog_category WHERE article_id = :article_id" );
        $sql->bindParam( ":article_id", $article_id );
        $sql->execute();
    }

    public function deleteByBlogCategoryID( $blog_category_id )
    {
        $sql = $this->DB->prepare( "DELETE FROM article_blog_category WHERE blog_category_id = :blog_category_id" );
        $sql->bindParam( ":blog_category_id", $blog_category_id );
        $sql->execute();
    }
}
