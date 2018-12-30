<?php

namespace Model\Mappers;

class UserProspectInteractionMapper extends DataMapper
{
    public function create( $user_id, $prospect_id, $interaction_type_id )
    {
        $id = $this->insert( "user_prospect_interaction", [ "user_id", "prospect_id", "interaction_type_id" ], [ $user_id, $propsect_id, $interaction_type_id ] );
        return $id;
    }

    public function mapAll()
    {
        $userProspectInteractions = [];
        $sql = $this->DB->prepare( "SELECT * FROM user_prospect_interaction" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $userProspectInteraction = $this->entityFactory->build( "UserProspectInteraction" );
            $this->populate( $userProspectInteraction, $resp );
            $userProspectInteractions[] = $userProspectInteraction;
        }

        return $userProspectInteractions;
    }

    public function mapFromID( \Model\UserProspectInteraction $userProspectInteraction, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM user_prospect_interaction WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $userProspectInteraction, $resp );

        return $userProspectInteraction;
    }

    public function mapFromUserID( \Model\UserProspectInteraction $userProspectInteraction, $user_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM user_prospect_interaction WHERE user_id = :user_id" );
        $sql->bindParam( ":user_id", $user_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $userProspectInteraction, $resp );

        return $userProspectInteraction;
    }

    public function mapFromMemberID( \Model\UserMemberInteraction $userMemberInteraction, $prospect_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM user_prospect_interaction WHERE prospect_id = :prospect_id" );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $userMemberInteraction, $resp );

        return $userMemberInteraction;
    }
}
