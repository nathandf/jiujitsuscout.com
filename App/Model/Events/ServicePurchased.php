<?php

namespace Model\Events;

use Contracts\MailerInterface;
use Model\Events\Event;

class ServicePurchased extends Event
{
	public $mailer;
	public $account_id;
	public $product_name;

	public function __construct( $mailer, $account_id, $product_name )
	{
		$this->mailer = $mailer;
		$this->account_id = $account_id;
		$this->product_name = $product_name;
	}
}
