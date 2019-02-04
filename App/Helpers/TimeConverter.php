<?php

namespace Helpers;

class TimeConverter
{
    public $valid_units = [ "seconds", "minutes", "hours", "days", "weeks", "months", "years" ];

    public function convertTo( $to_unit, $from_unit, $quanity )
    {
        
    }

    private function validateUnit( $unit )
    {
        if ( !in_array( $unit, $this->valid_units ) ) {
            throw new \Exception( "{$unit} is not a valid unit. Valid units: " . implode( ", ", $this->valid_units ) );
        }

        return true;
    }
}
