<?php

namespace Model\Services;

class InteractionTypeRepository extends Service
{

  public function getAll()
  {
    $interactionTypeMapper = new \Model\Mappers\InteractionTypeMapper( $this->container );
    $interactionTypes = $interactionTypeMapper->mapAll();
    return $interactionTypes;
  }

  public function getByID( $id )
  {
    $interactionType = new \Model\InteractionType();
    $interactionTypeMapper = new \Model\Mappers\InteractionTypeMapper( $this->container );
    $interactionTypeMapper->mapFromID( $interactionType, $id );

    return $interactionType;
  }

}
