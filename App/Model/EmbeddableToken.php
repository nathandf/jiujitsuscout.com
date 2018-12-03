<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormToken implements EntityInterface
{
	public $id;
	public $embeddable_form_id;
	public $token;
}
