<?php

namespace Models\Services;

class UserProspectInteractionRepository extends Service
{

  public function getAll()
  {
    $userProspectInteractionMapper = new \Models\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractions = $userProspectInteractionMapper->mapAll();
    return $userProspectInteractions;
  }

  public function getByID( $id )
  {
    $userProspectInteraction = new \Models\UserProspectInteraction();
    $userProspectInteractionMapper = new \Models\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

  public function getByUserID( $id )
  {
    $userProspectInteraction = new \Models\UserProspectInteraction();
    $userProspectInteractionMapper = new \Models\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromUserID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

  public function getByProspectID( $id )
  {
    $userProspectInteraction = new \Models\UserProspectInteraction();
    $userProspectInteractionMapper = new \Models\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromProspectID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

}
