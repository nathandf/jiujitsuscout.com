<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageSequenceTemplate implements EntityInterface
{
    public $id;
    public $landing_page_id;
    public $sequence_template_id;
}
