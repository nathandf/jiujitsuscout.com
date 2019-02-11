<?php

namespace Model\Mappers;

class TextMessageTemplateMapper extends DataMapper
{
    public function create( \Model\TextMessageTemplate $textMessageTemplate )
    {
        $id = $this->insert(
            "text_message_template",
            [ "business_id", "name", "description", "body" ],
            [ $textMessageTemplate->business_id, $textMessageTemplate->name, $textMessageTemplate->description, $textMessageTemplate->body ]
        );

        $textMessageTemplate->id = $id;

        return $textMessageTemplate;
    }

    public function mapAll()
    {
        
        $textMessageTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM text_message_template" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $textMessageTemplate, $resp );
            $textMessageTemplates[] = $textMessageTemplate;
        }

        return $textMessageTemplates;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        
        $textMessageTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM text_message_template WHERE business_id = :business_id" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $textMessageTemplate = $this->entityFactory->build( "TextMessageTemplate" );
            $this->populate( $textMessageTemplate, $resp );
            $textMessageTemplates[] = $textMessageTemplate;
        }

        return $textMessageTemplates;
    }

    public function mapFromID( \Model\TextMessageTemplate $textMessageTemplate, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM text_message_template WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $textMessageTemplate, $resp );

        return $textMessageTemplate;
    }

    public function updateByID( $id, $name, $description, $body )
    {
        $this->update( "text_message_template", "name", $name, "id", $id );
        $this->update( "text_message_template", "description", $description, "id", $id );
        $this->update( "text_message_template", "body", $body, "id", $id );
    }
}
