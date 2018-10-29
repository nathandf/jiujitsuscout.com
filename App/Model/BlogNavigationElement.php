<?php

namespace Model;

use Contracts\EntityInterface;

class BlogNavigationElement implements EntityInterface
{
    public $id;
    public $blog_id;
    public $blog_category_id;
    public $url;
    public $text;
}
