<?php

namespace Model\Mappers;

use Model\Review;

class ReviewMapper extends DataMapper
{

  public function create( \Model\Review $review )
  {
    $id = $this->insert(
                    "review",
                    [ "business_id", "name", "email", "rating", "review_body", "datetime" ],
                    [ $review->business_id, $review->name, $review->email, $review->rating, $review->review_body, $review->datetime ]
                  );
    $review->id = $id;
    return $review;
  }

  public function mapFromID( Review $review, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM review WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateReview( $review, $resp );
    return $review;
  }

    public function mapAllFromBusinessID( $business_id )
    {
        
        $reviews = [];
        $sql = $this->DB->prepare( 'SELECT * FROM review WHERE business_id = :business_id' );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $review = $this->entityFactory->build( "Review" );
            $this->populateReview( $review, $resp );
            $reviews[] = $review;
        }

        return $reviews;
    }

  private function populateReview( \Model\Review $review, $data )
  {
    $review->id                      = $data[ "id" ];
    $review->business_id             = $data[ "business_id" ];
    $review->name                    = $data[ "name" ];
    $review->email                   = $data[ "email" ];
    $review->review_body             = $data[ "review_body" ];
    $review->rating                  = $data[ "rating" ];
    $review->datetime                = $data[ "datetime" ];
  }

}
