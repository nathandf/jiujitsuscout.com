<?php

namespace Model\Services;

class TextMessageRepository extends Service
{

  public function getAll()
  {
    $textMessageMapper = new \Model\Mappers\TextMessageMapper( $this->container );
    $textMessages = $textMessageMapper->mapAll();
    return $textMessages;
  }

  public function getByID( $id )
  {
    $textMessage = new \Model\TextMessage();
    $textMessageMapper = new \Model\Mappers\TextMessageMapper( $this->container );
    $textMessageMapper->mapFromID( $textMessage, $id );
    return $textMessage;
  }

}
