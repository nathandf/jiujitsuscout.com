<?php

namespace Contracts;

interface Emailable
{
	public $subject;
	public $body;
	public $sender_name;
	public $sender_email_address;
	public $recipient_name;
	public $recipient_email_address;
}
