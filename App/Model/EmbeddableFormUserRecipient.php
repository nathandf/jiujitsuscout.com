<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormUserRecipient implements EntityInterface
{
	public $id;
	public $embeddable_form_id;
	public $user_id;
}