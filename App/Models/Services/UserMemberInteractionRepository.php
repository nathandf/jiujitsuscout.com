<?php

namespace Models\Services;

class UserMemberInteractionRepository extends Service
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

  public function getByMemberID( $id )
  {
    $userProspectInteraction = new \Models\UserProspectInteraction();
    $userProspectInteractionMapper = new \Models\Mappers\UserProspectInteractionMapper( $this->container );
    $userProspectInteractionMapper->mapFromMemberID( $userProspectInteraction, $id );

    return $userProspectInteraction;
  }

}
