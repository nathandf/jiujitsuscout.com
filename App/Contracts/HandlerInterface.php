<?php

namespace Contracts;

use Model\Events\Event;

interface HandlerInterface
{
	public function handle( Event $event );
}
