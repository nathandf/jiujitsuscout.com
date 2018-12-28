<?php

namespace Model\Services;

class EmailRepository extends Repository
{
    public function create( $business_id, $name, $description, $subject, $body )
    {
        $mapper = $this->getMapper();
        $email = $mapper->build( $this->entityName );
        $email->business_id = $business_id;
        $email->name = $name;
        $email->description = $description;
        $email->subject = $subject;
        $email->body = $body;
        $mapper->create( $email );

        return $email;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $emails = $mapper->mapAllFromBusinessID( $business_id );

        return $emails;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $email = $mapper->build( $this->entityName );
        $mapper->mapFromID( $email, $id );

        return $email;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $id, $name, $description, $subject, $body );
    }
}
