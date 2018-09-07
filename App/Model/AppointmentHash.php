<?php

namespace Model;

use Contracts\EntityInterface;

class AppointmentHash implements EntityInterface
{
    public $id;
    public $appointment_id;
    public $hash;
}
