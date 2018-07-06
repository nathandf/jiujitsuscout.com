<?php

namespace Models\Mappers;

class EmailMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $emails = [];
    $sql = $this->DB->prepare( "SELECT * FROM email" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $this->populateEmail( $email, $resp );
      $emails[] = $email;
    }
    return $emails;
  }

  public function mapFromID( \Models\Email $email, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM email WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEmail( $email, $resp );
    return $email;
  }

  private function populateEmail( \Models\Email $email, $data )
  {
    $email->id            = $data[ "id" ];
    $email->body          = $data[ "body" ];
  }

}
