<?php

namespace Models\Mappers;

class TextMessageMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $textMessages = [];
    $sql = $this->DB->prepare( "SELECT * FROM text_message" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $this->populateTextMessage( $textMessage, $resp );
      $textMessages[] = $textMessage;
    }
    return $textMessages;
  }

  public function mapFromID( \Models\TextMessage $textMessage, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM text_message WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateTextMessage( $textMessage, $resp );
    return $textMessage;
  }

  private function populateTextMessage( \Models\TextMessage $textMessage, $data )
  {
    $textMessage->id                  = $data[ "id" ];
    $textMessage->body                = $data[ "body" ];

  }

}
