<?php

namespace Model;

use Contracts\Emailable;

class Email implements Emailable
{
    public $subject;
    public $body;
    public $sender_name;
    public $sender_email;
    public $recipient_name;
    public $recipient_email;

    public function getSenderName()
    {
        return $this->sender_name;
    }

	public function getSenderEmail()
    {
        return $this->sender_email;
    }

	public function getRecipientName()
    {
        return $this->recipient_name;
    }

	public function getRecipientEmail()
    {
        return $this->recipient_name;
    }
}
