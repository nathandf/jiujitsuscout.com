<?php

namespace Contracts;

interface Emailable
{
	public function getSenderName();
	public function getSenderEmail();
	public function getRecipientName();
	public function getRecipientEmail();
}
