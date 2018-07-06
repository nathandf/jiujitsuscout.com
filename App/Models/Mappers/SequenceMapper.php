<?php

namespace Models\Mappers;

class SequenceMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $sequences = [];
    $sql = $this->DB->prepare( "SELECT * FROM sequence" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $sequence = $entityFactory->build( "Sequence" );
      $this->populateSequence( $sequence, $resp );
      $sequences[] = $sequence;
    }
    return $sequences;
  }

  public function mapAllFromCheckedOut()
  {
    $checked_out = 0;
    $entityFactory = $this->container->getService( "entity-factory" );
    $sequences = [];
    $sql = $this->DB->prepare( "SELECT * FROM sequence WHERE checked_out = :checked_out" );
    $sql->bindParam( ":checked_out", $checked_out );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $sequence = $entityFactory->build( "Sequence" );
      $this->populateSequence( $sequence, $resp );
      $sequences[] = $sequence;
    }
    return $sequences;
  }

  public function updateCheckedOutByID( $checked_out, $id )
  {
    $this->update( "sequence", "checked_out", $checked_out, "id", $id );
  }

  private function populateSequence( \Models\Sequence $sequence, $data )
  {
    $sequence->id          = $data[ "id" ];
    $sequence->name        = $data[ "name" ];
    $sequence->description = $data[ "description" ];
    $sequence->event_ids   = $data[ "event_ids" ];
    $sequence->checked_out = $data[ "checked_out" ];
  }

}
