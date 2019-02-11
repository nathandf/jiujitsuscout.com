<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageGroup implements EntityInterface
{
    public $id;
    public $landing_page_id;
    public $group_id;
}
