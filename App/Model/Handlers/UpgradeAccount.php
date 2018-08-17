<?php

namespace Model\Handlers;

use Contracts\HandlerInterface;
use Model\Events\Event;

class UpgradeAccount implements HandlerInterface
{
	public function handle( Event $event )
	{
		$event->accountRepo->updateAccountTypeIDByID( $event->account_id, $event->account_type_id );
	}
}
