<?php

namespace Model\Services;

class TextMessageRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $textMessages = $mapper->mapAll();

        return $textMessages;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $textMessage = $mapper->build( $this->entityName );
        $mapper->mapFromID( $textMessage, $id );

        return $textMessage;
    }
}
