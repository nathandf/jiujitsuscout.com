<?php

namespace Model;

use Contracts\EntityInterface;

class BlogCategory implements EntityInterface
{
    public $id;
    public $blog_id;
    public $name;
    public $url;
    public $title;
    public $description;
}
