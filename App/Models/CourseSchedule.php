<?php

namespace Model;

use Contracts\EntityInterface;

class CourseSchedule implements EntityInterface
{
    public $id;
    public $course_id;
    public $schedule_id;

}
