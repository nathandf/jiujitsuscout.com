<?php

namespace Model\Mappers;

class SequenceTemplateMapper extends DataMapper
{
    public function create( \Model\SequenceTemplate $sequenceTemplate )
    {
        $id = $this->insert(
            "sequence_template",
            [ "business_id", "name", "description" ],
            [ $sequenceTemplate->business_id, $sequenceTemplate->name, $sequenceTemplate->description ]
        );
        $sequenceTemplate->id = $id;

        return $sequenceTemplate;
    }

    public function mapFromID( \Model\SequenceTemplate $sequenceTemplate, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM sequence_template WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $sequenceTemplate, $resp );

        return $sequenceTemplate;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $sequenceTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM sequence_template" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $sequenceTemplate = $entityFactory->build( "SequenceTemplate" );
            $this->populate( $sequenceTemplate, $resp );
            $sequenceTemplates[] = $sequenceTemplate;
        }

        return $sequenceTemplates;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $sequenceTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM sequence_template WHERE business_id = :business_id" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $sequenceTemplate = $entityFactory->build( "SequenceTemplate" );
            $this->populate( $sequenceTemplate, $resp );
            $sequenceTemplates[] = $sequenceTemplate;
        }

        return $sequenceTemplates;
    }

    public function updateByID( $id, $name, $description )
    {
        $this->update( "sequence_template", "name", $name, "id", $id );
        $this->update( "sequence_template", "description", $description, "id", $id );
    }

}
