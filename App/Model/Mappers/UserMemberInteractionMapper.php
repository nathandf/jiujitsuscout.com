<?php

namespace Model\Mappers;

class UserMemberInteractionMapper extends DataMapper
{

  public function create( $user_id, $member_id, $interaction_type_id )
  {
    $id = $this->insert( "user_member_interaction", [ "user_id", "member_id", "interaction_type_id" ], [ $user_id, $propsect_id, $interaction_type_id ] );
    return $id;
  }

  public function mapAll()
  {
    
    $userMemberInteractions = [];
    $sql = $this->DB->prepare( "SELECT * FROM user_member_interaction" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $userMemberInteraction = $this->entityFactory->build( "UserMemberInteraction" );
      $this->populateUserMemberInteraction( $userMemberInteraction, $resp );
      $userMemberInteractions[] = $userMemberInteraction;
    }

    return $userMemberInteractions;
  }

  public function mapFromID( \Model\UserMemberInteraction $userMemberInteraction, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM user_member_interaction WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateUserMemberInteraction( $userMemberInteraction, $resp );
    return $userMemberInteraction;
  }

  public function mapFromUserID( \Model\UserMemberInteraction $userMemberInteraction, $user_id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM user_member_interaction WHERE user_id = :user_id" );
    $sql->bindParam( ":user_id", $user_id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateUserMemberInteraction( $userMemberInteraction, $resp );
    return $userMemberInteraction;
  }

  public function mapFromMemberID( \Model\UserMemberInteraction $userMemberInteraction, $member_id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM user_member_interaction WHERE member_id = :member_id" );
    $sql->bindParam( ":member_id", $member_id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateUserMemberInteraction( $userMemberInteraction, $resp );
    return $userMemberInteraction;
  }

  private function populateUserMemberInteraction( \Model\UserMemberInteraction $userMemberInteraction, $data )
  {
    $userMemberInteraction->id                  = $data[ "id" ];
    $userMemberInteraction->user_id             = $data[ "user_id" ];
    $userMemberInteraction->member_id         = $data[ "member_id" ];
    $userMemberInteraction->interaction_type_id = $data[ "interaction_type_id" ];
  }

}
