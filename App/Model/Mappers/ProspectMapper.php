<?php

namespace Model\Mappers;

use Model\Prospect;

class ProspectMapper extends DataMapper
{
    public function create( Prospect $prospect )
    {
        $id = $this->insert(
            "prospect",
            [ "first_name", "last_name", "email", "phone_id", "business_id", "source" ],
            [ $prospect->first_name, $prospect->last_name, $prospect->email, $prospect->phone_id, $prospect->business_id, $prospect->source ]
        );

        return $id;
    }

    public function updatePhoneIDByID( $phone_id, $id )
    {
        $this->update( "prospect", "phone_id", $phone_id, "id", $id );
    }

    public function updateAddressIDByID( $address_id, $id )
    {
        $this->update( "prospect", "address_id", $address_id, "id", $id );
    }

    // start and end time expected to be unix timestamp
    public function updateTrialTimesByID( $id, $start_time, $end_time )
    {
        $this->update( "prospect", "trial_start", $start_time, "id", $id );
        $this->update( "prospect", "trial_end", $end_time, "id", $id );
    }

    public function updateTypeByID( $type, $id )
    {
        $this->update( "prospect", "type", $type, "id", $id );
    }

    public function updateTimesContactedByID( $times_contacted, $id )
    {
        $this->update( "prospect", "times_contacted", $times_contacted, "id", $id );
    }

    public function updateStatusByID( $status, $id )
    {
        $this->update( "prospect", "status", $status, "id", $id );
    }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $this->update( "prospect", "group_ids", $group_ids, "id", $id );
    }

    public function mapAll()
    {
        $prospects = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospect = $this->entityFactory->build( "Prospect" );
            $this->populate( $prospect, $resp );
            $prospects[] = $prospect;
        }

        return $prospects;
    }

    public function mapFromID( Prospect $prospect, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM prospect WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $prospect, $resp );

        return $prospect;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $prospects = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect WHERE business_id = :business_id ORDER BY id DESC" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospect = $this->entityFactory->build( "Prospect" );
            $this->populate( $prospect, $resp );
            $prospects[] = $prospect;
        }

        return $prospects;
    }

    public function mapAllFromTypeAndBusinessID( $type, $business_id )
    {
        $prospects = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect WHERE type = :type AND business_id = :business_id ORDER BY id DESC" );
        $sql->bindParam( ":type", $type );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospect = $this->entityFactory->build( "Prospect" );
            $this->populate( $prospect, $resp );
            $prospects[] = $prospect;
        }

        return $prospects;
    }

    public function mapAllFromType( $type )
    {
        $prospects = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect WHERE type = :type" );
        $sql->bindParam( ":type", $type );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospect = $this->entityFactory->build( "Prospect" );
            $this->populate( $prospect, $resp );
            $prospects[] = $prospect;
        }

        return $prospects;
    }

    public function mapAllFromStatusAndBusinessID( $status, $business_id )
    {
        $prospects = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect WHERE status = :status AND business_id = :business_id ORDER BY id DESC" );
        $sql->bindParam( ":status", $status );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospect = $this->entityFactory->build( "Prospect" );
            $this->populate( $prospect, $resp );
            $prospects[] = $prospect;
        }

        return $prospects;
    }

    public function updateProspectByID( $id, $prospect )
    {
        $this->update( "prospect", "first_name", $prospect->first_name, "id", $id );
        $this->update( "prospect", "last_name", $prospect->last_name, "id", $id );
        $this->update( "prospect", "email", $prospect->email, "id", $id );
        $this->update( "prospect", "address_1", $prospect->address_1, "id", $id );
        $this->update( "prospect", "address_2", $prospect->address_2, "id", $id );
        $this->update( "prospect", "city", $prospect->city, "id", $id );
        $this->update( "prospect", "region", $prospect->region, "id", $id );
    }

    public function updateRequiresPurchaseByID( $id, $value )
    {
        $this->update( "prospect", "requires_purchase", $value, "id", $id );
    }

    public function updateTrialRemindStatusByID( $id, $status )
    {
        $this->update( "prospect", "trial_remind_status", $status, "id", $id );
    }
}
