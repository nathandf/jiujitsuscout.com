<?php

namespace Model;

use Contracts\EntityInterface;

class Country implements EntityInterface
{
    public $id;
    public $iso;
    public $iso3;
    public $name;
    public $nicename;
    public $phonecode;
    public $numcode;
}
