<?php

namespace Models\Services;

class EmailBuilder extends Service
{
	public function setSubject( $subject )
	{

	}

	public function buildEmail()
	{

	}

	private setEmail( $email )
	{
		$this->email = $email;
	}

	public getEmail()
	{
		if ( isset( $this->email ) ) {
			return $this->email;
		}

		return null;
	}
}
