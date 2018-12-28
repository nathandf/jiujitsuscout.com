<?php

namespace Model\Mappers;

class InteractionTypeMapper extends DataMapper
{

  public function mapAll()
  {
    
    $interactionTypes = [];
    $sql = $this->DB->prepare( "SELECT * FROM interaction_type" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $interactionType = $this->entityFactory->build( "InteractionType" );
      $this->populateInteractionType( $interactionType, $resp );
      $interactionTypes[] = $interactionType;
    }

    return $interactionTypes;
  }

  public function mapFromID( \Model\InteractionType $interactionType, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM interaction_type WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateInteractionType( $interactionType, $resp );
    return $interactionType;
  }

  private function populateInteractionType( \Model\InteractionType $interactionType, $data )
  {
    $interactionType->id                = $data[ "id" ];
    $interactionType->name              = $data[ "name" ];
    $interactionType->description       = $data[ "description" ];
  }

}
