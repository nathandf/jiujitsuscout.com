<?php

namespace Models\Services;

class InteractionTypeRepository extends Service
{

  public function getAll()
  {
    $interactionTypeMapper = new \Models\Mappers\InteractionTypeMapper( $this->container );
    $interactionTypes = $interactionTypeMapper->mapAll();
    return $interactionTypes;
  }

  public function getByID( $id )
  {
    $interactionType = new \Models\InteractionType();
    $interactionTypeMapper = new \Models\Mappers\InteractionTypeMapper( $this->container );
    $interactionTypeMapper->mapFromID( $interactionType, $id );

    return $interactionType;
  }

}
