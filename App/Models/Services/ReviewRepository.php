<?php

namespace Models\Services;

class ReviewRepository extends Service
{

    public function create( $business_id, $name, $email, $review_body, $rating, $datetime )
    {
        $review = new \Models\Review();
        $reviewMapper = new \Models\Mappers\ReviewMapper( $this->container );
        $review->business_id = $business_id;
        $review->name = $name;
        $review->email = $email;
        $review->review_body = $review_body;
        $review->rating = $rating;
        $review->datetime = $datetime;
        $reviewMapper->create( $review );

        return $review;
    }

    public function getByID( $id )
    {
        $review = new \Models\Review();
        $reviewMapper = new \Models\Mappers\ReviewMapper( $this->container );
        $reviewMapper->mapFromID( $review, $id );

        return $review;
    }

    public function getAllByBusinessID( $id )
    {
        $reviewMapper = new \Models\Mappers\ReviewMapper( $this->container );
        $reviews = $reviewMapper->mapAllFromBusinessID( $id );
        return $reviews;
    }

}
