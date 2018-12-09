<?php

namespace Model\Mappers;

class EmailMapper extends DataMapper
{
    public function create( \Model\Email $email )
    {
        $id = $this->insert(
            "email",
            [ "business_id", "name", "description", "subject", "body" ],
            [ $email->business_id, $email->name, $email->description, $email->subject, $email->body ]
        );
        $email->id = $id;

        return $email;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $emails = [];
        $sql = $this->DB->prepare( "SELECT * FROM email WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $email = $entityFactory->build( "Email" );
            $this->populate( $email, $resp );
            $emails[] = $email;
        }

        return $emails;
    }

    public function mapFromID( \Model\Email $email, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM email WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $email, $resp );

        return $email;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $this->update( "email", "name", $name, "id", $id );
        $this->update( "email", "description", $description, "id", $id );
        $this->update( "email", "subject", $subject, "id", $id );
        $this->update( "email", "body", $body, "id", $id );
    }
}
