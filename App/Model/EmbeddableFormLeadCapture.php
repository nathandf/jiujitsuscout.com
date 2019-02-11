<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormLeadCapture implements EntityInterface
{
	public $id;
	public $embeddable_form_id;
	public $lead_capture_id;
}