<?php

namespace Model\Services;

class ReviewRepository extends Repository
{

    public function create( $business_id, $name, $email, $review_body, $rating, $datetime )
    {
        $mapper = $this->getMapper();
        $review = $mapper->build( $this->entityName );
        $review->business_id = $business_id;
        $review->name = $name;
        $review->email = $email;
        $review->review_body = $review_body;
        $review->rating = $rating;
        $review->datetime = $datetime;
        $mapper->create( $review );

        return $review;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $review = $mapper->build( $this->entityName );
        $mapper->mapFromID( $review, $id );

        return $review;
    }

    public function getAllByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $reviews = $mapper->mapAllFromBusinessID( $id );
        return $reviews;
    }

}
