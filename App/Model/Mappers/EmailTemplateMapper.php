<?php

namespace Model\Mappers;

class EmailTemplateMapper extends DataMapper
{
    public function create( \Model\EmailTemplate $emailTemplate )
    {
        $id = $this->insert(
            "email_template",
            [ "business_id", "name", "description", "subject", "body" ],
            [ $emailTemplate->business_id, $emailTemplate->name, $emailTemplate->description, $emailTemplate->subject, $emailTemplate->body ]
        );
        $emailTemplate->id = $id;

        return $emailTemplate;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        
        $emailTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM email_template WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $emailTemplate = $this->entityFactory->build( "EmailTemplate" );
            $this->populate( $emailTemplate, $resp );
            $emailTemplates[] = $emailTemplate;
        }

        return $emailTemplates;
    }

    public function mapFromID( \Model\EmailTemplate $emailTemplate, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM email_template WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $emailTemplate, $resp );

        return $emailTemplate;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $this->update( "email_template", "name", $name, "id", $id );
        $this->update( "email_template", "description", $description, "id", $id );
        $this->update( "email_template", "subject", $subject, "id", $id );
        $this->update( "email_template", "body", $body, "id", $id );
    }
}
