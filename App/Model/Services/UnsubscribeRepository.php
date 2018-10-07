<?php

namespace Model\Services;

use Model\Unsubscribe;
use Model\Mappers\UnsubscribeMapper;

class UnsubscribeRepository extends Service
{

    public function create( $email )
    {
        $unsubscribe = new Unsubscribe();
        $unsubscribeMapper = new UnsubscribeMapper( $this->container );
        $unsubscribe->email = $email;

        $unsubscribeMapper->create( $unsubscribe );

        return $unsubscribe;
    }

    public function getByID( $id )
    {
        $unsubscribe = new Unsubscribe();
        $unsubscribeMapper = new UnsubscribeMapper( $this->container );
        $unsubscribeMapper->mapFromID( $unsubscribe, $id );

        return $unsubscribe;
    }

    public function getByEmail( $email )
    {
        $unsubscribe = new Unsubscribe();
        $unsubscribeMapper = new UnsubscribeMapper( $this->container );
        $unsubscribeMapper->mapFromID( $unsubscribe, $email );

        return $unsubscribe;
    }

    public function getAll()
    {
        $unsubscribeMapper = new \Model\Mappers\UnsubscribeMapper( $this->container );
        $unsubscribes = $unsubscribeMapper->mapAll();

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
