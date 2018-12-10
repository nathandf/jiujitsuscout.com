<?php

namespace Helpers;

class EmailerHelper
{
	public $sender_name;
	public $sender_email;
	public $recipient_name;
	public $recipient_email;
	public $error_messages = [];

	public function setSenderName( $sender_name )
	{
		$this->sender_name = $sender_name;
	}

	public function setSenderEmail( $sender_email )
	{
		if ( !$this->validateEmail( $sender_email ) ) {
			$this->addErrorMessage( "Sender Email is not a valid email address" );
		}

		$this->sender_email = $sender_email;
	}

	public function setRecipientName( $recipient_name )
	{
		$this->recipient_name = $recipient_name;
	}

	public function setRecipientEmail( $recipient_email )
	{
		if ( !$this->validateEmail( $recipient_email ) ) {
			$this->addErrorMessage( "Recipient Email is not a valid email address" );
		}

		$this->recipient_email = $recipient_email;
	}

	public function addErrorMessage( $message )
	{
		$this->error_messages[] = $message;
	}

	public function getErrorMessages()
	{
		return $this->error_messages;
	}

	public function validateEmail( $email )
	{
		if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) !== false ) {
			return true;
        }

		return false;
	}

	public function ready()
	{
		if ( isset(	$this->sender_name, $this->sender_email, $this->recipient_name, $this->recipient_email ) ) {
			if ( count( $this->getErrorMessages() ) < 1 ) {
				return true;
			}
		}

		return false;
	}

}
