<?php

namespace Model;

use Contracts\EntityInterface;

class Search implements EntityInterface
{
    public $id;
    public $ip;
    public $query;
    public $time;
}
