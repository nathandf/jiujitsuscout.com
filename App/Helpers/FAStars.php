<?php

namespace Helpers;

class FAStars
{
    public function show( $rating, $max_rating = 5, $star_color = '#F9BF54')
    {
        $stars = "";

        $whole_star_html = '<i class="fa fa-star star" style="color: ' . $star_color . '" aria-hidden="true"></i>';
        $half_star_html = '<i class="fa fa-star-half-o" style="color: ' . $star_color . '" aria-hidden="true"></i>';
        $empty_star_html = '<i class="fa fa-star-o star" style="color: ' . $star_color . '" aria-hidden="true"></i>';

        $rating_whole = floor( $rating );
        $rating_decimal = $rating - $rating_whole;
        $whole_stars = $rating_whole;
        $empty_stars = $max_rating - $rating_whole - $rating_decimal;

        if( $rating > 0 ) {
            for( $i=1; $i <= $whole_stars; $i++ ) {
                $stars = $stars . $whole_star_html;
            }
            if( $rating_decimal > 0 ) {
                $stars = $stars . $half_star_html;
            }
            for( $i=1; $i <= $empty_stars; $i++ ) {
                $stars = $stars . $empty_star_html;
            }
        } else {
            for( $i=1; $i <= $max_rating; $i++ ) {
                $stars = $stars . $empty_star_html;
            }
        }

        return $stars;
    }

}
