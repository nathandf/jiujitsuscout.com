<?php

namespace Model\Services;

class EmailRepository extends Service
{
    public function create( $business_id, $name, $description, $subject, $body )
    {
        $email = new \Model\Email;
        $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
        $email->business_id = $business_id;
        $email->name = $name;
        $email->description = $description;
        $email->subject = $subject;
        $email->body = $body;
        $emailMapper->create( $email );

        return $email;
    }

    public function getAllByBusinessID( $business_id )
    {
        $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
        $emails = $emailMapper->mapAllFromBusinessID( $business_id );

        return $emails;
    }

    public function getByID( $id )
    {
        $email = new \Model\Email();
        $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
        $emailMapper->mapFromID( $email, $id );

        return $email;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
        $emailMapper->updateByID( $id, $name, $description, $subject, $body );
    }
}
