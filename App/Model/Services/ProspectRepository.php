<?php

namespace Model\Services;

class ProspectRepository extends Service
{

  public function save( \Model\Prospect $prospect )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $id = $prospectMapper->create( $prospect );

    return $id;
  }

  public function getAll()
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospects = $prospectMapper->mapAll();
    return $prospects;
  }

  public function getByID( $id )
  {
    $prospect = new \Model\Prospect();
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->mapFromID( $prospect, $id );
    return $prospect;
  }

  public function getAllByBusinessID( $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospects = $prospectMapper->mapAllFromBusinessID( $id );
    return $prospects;
  }

  public function getAllByStatusAndBusinessID( $status, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospects = $prospectMapper->mapAllFromStatusAndBusinessID( $status, $id );
    return $prospects;
  }

  public function getAllByTypeAndBusinessID( $type, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospects = $prospectMapper->mapAllFromTypeAndBusinessID( $type, $id );
    return $prospects;
  }

    public function getAllByType( $type )
    {
        $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
        $prospects = $prospectMapper->mapAllFromType( $type );

        return $prospects;
    }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updatePhoneIDByID( $phone_id, $id );

    return true;
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateAddressIDByID( $address_id, $id );

    return true;
  }


  // trial times expected to be unix timestamps
  public function updateTrialTimesByID( $id, $trial_start, $trial_end )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateTrialTimesByID( $id, $trial_start, $trial_end );
  }

  public function updateTypeByID( $type, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateTypeByID( $type, $id );
  }

  public function updateStatusByID( $status, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateStatusByID( $status, $id );
  }

  public function updateTimesContactedByID( $times_contacted, $id )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateTimesContactedByID( $times_contacted, $id );
  }

  public function updateProspectByID( $id, \Model\Prospect $prospect )
  {
    $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
    $prospectMapper->updateProspectByID( $id, $prospect );
  }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
        $prospectMapper->updateGroupIDsByID( $group_ids, $id );
    }

    public function updateTrialRemindStatusByID( $id, $status = 1 )
    {
        $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
        $prospectMapper->updateTrialRemindStatusByID( $id, $status );
    }

    public function updateRequiresPurchaseByID( $id, $value = 1 )
    {
        $prospectMapper = new \Model\Mappers\ProspectMapper( $this->container );
        $prospectMapper->updateRequiresPurchaseByID( $id, $value );
    }

}
