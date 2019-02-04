<?php

namespace Model\Services;

class EmailBuilder extends Service
{
	public function setSubject( $subject )
	{

	}

	public function buildEmail()
	{

	}

	private function setEmail( $email )
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		if ( isset( $this->email ) ) {
			return $this->email;
		}

		return null;
	}
}
