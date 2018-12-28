<?php

namespace Model\Services;

class ProspectRepository extends Repository
{
    public function save( \Model\Prospect $prospect )
    {
        $mapper = $this->getMapper();
        $id = $mapper->create( $prospect );

        return $id;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $prospects = $mapper->mapAll();

        return $prospects;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $prospect = $mapper->build( $this->entityName );
        $mapper->mapFromID( $prospect, $id );

        return $prospect;
    }

    public function getAllByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $prospects = $mapper->mapAllFromBusinessID( $id );

        return $prospects;
    }

    public function getAllByStatusAndBusinessID( $status, $id )
    {
        $mapper = $this->getMapper();
        $prospects = $mapper->mapAllFromStatusAndBusinessID( $status, $id );

        return $prospects;
    }

    public function getAllByTypeAndBusinessID( $type, $id )
    {
        $mapper = $this->getMapper();
        $prospects = $mapper->mapAllFromTypeAndBusinessID( $type, $id );

        return $prospects;
    }

    public function getAllByType( $type )
    {
        $mapper = $this->getMapper();
        $prospects = $mapper->mapAllFromType( $type );

        return $prospects;
    }

    public function updatePhoneIDByID( $phone_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePhoneIDByID( $phone_id, $id );

        return true;
    }

    public function updateAddressIDByID( $address_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateAddressIDByID( $address_id, $id );

        return true;
    }


    // trial times expected to be unix timestamps
    public function updateTrialTimesByID( $id, $trial_start, $trial_end )
    {
        $mapper = $this->getMapper();
        $mapper->updateTrialTimesByID( $id, $trial_start, $trial_end );
    }

    public function updateTypeByID( $type, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateTypeByID( $type, $id );
    }

    public function updateStatusByID( $status, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateStatusByID( $status, $id );
    }

    public function updateTimesContactedByID( $times_contacted, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateTimesContactedByID( $times_contacted, $id );
    }

    public function updateProspectByID( $id, \Model\Prospect $prospect )
    {
        $mapper = $this->getMapper();
        $mapper->updateProspectByID( $id, $prospect );
    }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateGroupIDsByID( $group_ids, $id );
    }

    public function updateTrialRemindStatusByID( $id, $status = 1 )
    {
        $mapper = $this->getMapper();
        $mapper->updateTrialRemindStatusByID( $id, $status );
    }

    public function updateRequiresPurchaseByID( $id, $value = 1 )
    {
        $mapper = $this->getMapper();
        $mapper->updateRequiresPurchaseByID( $id, $value );
    }
}
