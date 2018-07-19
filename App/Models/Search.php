<?php

namespace Models;

use Contracts\EntityInterface;

class Search implements EntityInterface
{

    public $id;
    public $query;
    public $time;

}
