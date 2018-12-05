<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormElement implements EntityInterface
{
	public $id;
	public $embeddable_form_id;
	public $embeddable_form_element_type_id;
	public $placement;
	public $text;
	public $required;
}
