<?php

namespace Model;

use Contracts\EntityInterface;

class FAQAnswer implements EntityInterface
{
    public $id;
    public $business_id;
    public $faq_id;
    public $text;
}
