<?php

namespace Model;

use Contracts\EntityInterface;

class Review implements EntityInterface
{

  public $id;
  public $business_id;
  public $rating;
  public $review_body;
  public $name;
  public $email;
  public $datetime;

}
