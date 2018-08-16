<?php

namespace Model\Events;

use Contracts\HandlerInterface;

abstract class Event
{
	protected $handlers = [];

	public function attach( $handlers )
	{
		if ( is_array( $handlers ) ) {
			foreach ( $handlers as $handler ) {
				if ( $handler instanceof HandlerInterface ) {
					continue;
				}
				// Attach handler to event
				$this->handlers[] = $handler;
			}

			return;
		}

		if ( !$handlers instanceof HandlerInterface  ) {
			return;
		}
		// Attach single handler
		$this->handlers[] = $handlers;
	}

	public function dispatch()
	{
		foreach ( $this->handlers as $handler ) {
			$handler->handle( $this );
		}
	}
}
