<?php

namespace Helpers;

class Geometry
{
    // Earth radius in meters
    public $earth_radius = 6371000;

    public function haversineGreatCircleDistance( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = "mi" ) {
        // convert from degrees to radians
        $latFrom  = deg2rad( $latitudeFrom );
        $lonFrom  = deg2rad( $longitudeFrom );
        $latTo    = deg2rad( $latitudeTo );
        $lonTo    = deg2rad( $longitudeTo );
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle    = 2 * asin( sqrt( pow( sin( $latDelta / 2 ), 2 ) + cos( $latFrom ) * cos( $latTo ) * pow( sin( $lonDelta / 2 ), 2 ) ) );
        $meters   = ( $angle * $this->earth_radius );
        $distance = $meters / 1609.34;

        // Return kilometers if specified in params
        if ( $unit == "km" ) {
            $distance = $meters / 1000;
        }

        return $distance;
    }

}
