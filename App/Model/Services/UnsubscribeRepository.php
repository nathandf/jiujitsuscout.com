<?php

namespace Model\Services;

use Model\Unsubscribe;
use Model\Mappers\UnsubscribeMapper;

class UnsubscribeRepository extends Repository
{
    public function create( $email )
    {
        $mapper = $this->getMapper();
        $unsubscribe = $mapper->build( $this->entityName );
        $unsubscribe->email = $email;

        $mapper->create( $unsubscribe );

        return $unsubscribe;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $unsubscribe = $mapper->build( $this->entityName );
        $mapper->mapFromID( $unsubscribe, $id );

        return $unsubscribe;
    }

    public function getByEmail( $email )
    {
        $mapper = $this->getMapper();
        $unsubscribe = $mapper->build( $this->entityName );
        $mapper->mapFromID( $unsubscribe, $email );

        return $unsubscribe;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $unsubscribes = $mapper->mapAll();

        return $unsubscribes;
    }

    public function getAllEmails()
    {
        $unsubscribes = $this->getAll();

        $emails = [];

		foreach ( $unsubscribes as $unsubscribe ) {
			$emails[] = $unsubscribe->email;
		}

        return $emails;
    }
}
