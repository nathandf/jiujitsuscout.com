<?php

namespace Models\Services;

class TextMessageRepository extends Service
{

  public function getAll()
  {
    $textMessageMapper = new \Models\Mappers\TextMessageMapper( $this->container );
    $textMessages = $textMessageMapper->mapAll();
    return $textMessages;
  }

  public function getByID( $id )
  {
    $textMessage = new \Models\TextMessage();
    $textMessageMapper = new \Models\Mappers\TextMessageMapper( $this->container );
    $textMessageMapper->mapFromID( $textMessage, $id );
    return $textMessage;
  }

}
