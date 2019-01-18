<?php

namespace Model;

use Contracts\EntityInterface;

class LeadCapture implements EntityInterface
{
    public $id;
    public $prospect_id;
}
