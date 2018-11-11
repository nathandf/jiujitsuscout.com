<?php

namespace Model;

use Contracts\EntityInterface;

class ArticleBlogCategory implements EntityInterface
{
    public $id;
    public $article_id;
    public $blog_category_id;
}
