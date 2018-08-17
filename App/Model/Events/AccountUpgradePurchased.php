<?php

namespace Model\Events;

use Model\Services\AccountRepository;
use Model\Events\Event;

class AccountUpgradePurchased extends Event
{
	public $accountRepo;
	public $account_id;
	public $account_type_id;

	public function __construct( AccountRepository $accountRepo, $account_id, $account_type_id )
	{
		$this->accountRepo = $accountRepo;
		$this->account_id = $account_id;
		$this->account_type_id = $account_type_id;
	}
}
