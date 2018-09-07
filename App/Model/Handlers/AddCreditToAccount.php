<?php

namespace Model\Handlers;

use Contracts\HandlerInterface;
use Model\Events\Event;

class AddCreditToAccount implements HandlerInterface
{
	public function handle( Event $event )
	{
		$event->accountRepo->addAccountCreditByID( $event->account_id, $event->amount );
	}
}
