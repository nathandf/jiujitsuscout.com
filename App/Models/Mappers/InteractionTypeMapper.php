<?php

namespace Models\Mappers;

class InteractionTypeMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $interactionTypes = [];
    $sql = $this->DB->prepare( "SELECT * FROM interaction_type" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $interactionType = $entityFactory->build( "InteractionType" );
      $this->populateInteractionType( $interactionType, $resp );
      $interactionTypes[] = $interactionType;
    }

    return $interactionTypes;
  }

  public function mapFromID( \Models\InteractionType $interactionType, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM interaction_type WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateInteractionType( $interactionType, $resp );
    return $interactionType;
  }

  private function populateInteractionType( \Models\InteractionType $interactionType, $data )
  {
    $interactionType->id                = $data[ "id" ];
    $interactionType->name              = $data[ "name" ];
    $interactionType->description       = $data[ "description" ];
  }

}
