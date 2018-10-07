<?php

namespace Model\Events;

use Model\Services\AccountRepository;
use Model\Events\Event;

class AccountCreditPurchased extends Event
{
	public $accountRepo;
	public $account_id;
	public $amount;

	public function __construct( AccountRepository $accountRepo, $account_id, $amount )
	{
		$this->accountRepo = $accountRepo;
		$this->account_id = $account_id;
		$this->amount = $amount;
	}
}
