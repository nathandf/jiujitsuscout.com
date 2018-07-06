<?php

namespace Models;

use Contracts\EntityInterface;

class Course implements EntityInterface
{
    public $id;
    public $business_id;
    public $discipline_id;
    public $name;
    public $description;
    public $day;
    public $start_time;
    public $end_time;

    public function setDay( $day )
    {
        $this->day = trim( strtolower( $day ) );
    }

}
