<?php

namespace Model;

use Contracts\EntityInterface;

class ProspectSource implements EntityInterface
{
	public $id;
	public $prospect_id;
	public $embeddable_form_id;
	public $landing_page_id;
}
