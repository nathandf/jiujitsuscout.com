<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageElement implements EntityInterface
{
	public $id;
	public $landing_page_id;
	public $landing_page_element_type_id;
	public $parent_landing_page_element_id;
	public $landing_page_element_css_id;
}