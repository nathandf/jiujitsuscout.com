<?php

namespace Contracts;

interface EventInterface
{
	public function dispatch( array $params );
}
