<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormRedirect implements EntityInterface
{
	public $id;
	public $embeddable_form_id;
	public $url;
}
