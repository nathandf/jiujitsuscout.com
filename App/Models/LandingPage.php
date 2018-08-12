<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPage implements EntityInterface
{

  public $id;
  public $name;
  public $slug;
  public $business_id;
  public $group_ids;
  public $facebook_pixel_id;
  public $call_to_action;
  public $call_to_action_form;
  public $headline;
  public $text_a;
  public $text_b;
  public $text_c;
  public $text_form;
  public $image_background;
  public $image_a;
  public $image_b;
  public $image_c;
  public $template_file;

  public function formatSlug( $slug )
  {
    $slug = strtolower( $slug );
    // replace all spaces with hyphens
    $slug = preg_replace( "/[\s]/", "-", $slug );
    // replace all non-alphanumeric chars and underscores with nothing
    $slug = preg_replace( "/[^a-zA-Z0-9-]/", "", $slug );
    // replace double hypens with a single instance
    $slug = preg_replace( "/-+/", "-", $slug );
    return $slug;
  }

}
