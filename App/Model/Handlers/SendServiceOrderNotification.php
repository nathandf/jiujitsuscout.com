<?php

namespace Model\Handlers;

use Contracts\HandlerInterface;
use Model\Events\Event;

class SendServiceOrderNotification implements HandlerInterface
{
	public function handle( Event $event )
	{
		$event->mailer->sendServiceOrderNotification( $event->account_id, $event->product_name );
	}
}
