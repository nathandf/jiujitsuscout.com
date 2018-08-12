<?php

namespace Model\Services;

class UserProspectInteractionRepository extends Service
{

  public function getAll()
  {
    $userProspectInteractionMapper = new \Model\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractions = $userProspectInteractionMapper->mapAll();
    return $userProspectInteractions;
  }

  public function getByID( $id )
  {
    $userProspectInteraction = new \Model\UserProspectInteraction();
    $userProspectInteractionMapper = new \Model\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

  public function getByUserID( $id )
  {
    $userProspectInteraction = new \Model\UserProspectInteraction();
    $userProspectInteractionMapper = new \Model\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromUserID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

  public function getByProspectID( $id )
  {
    $userProspectInteraction = new \Model\UserProspectInteraction();
    $userProspectInteractionMapper = new \Model\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromProspectID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

}
