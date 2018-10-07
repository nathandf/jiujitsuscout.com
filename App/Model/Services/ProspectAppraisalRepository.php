<?php

namespace Model\Services;

class ProspectAppraisalRepository extends Service
{
    public function create( $prospect_id, $value, $currency = "USD" )
    {
        $prospectAppraisal = new \Model\ProspectAppraisal();
        $prospectAppraisalMapper = new \Model\Mappers\ProspectAppraisalMapper( $this->container );
        $prospectAppraisal->prospect_id = $prospect_id;
        $prospectAppraisal->value = $value;
        $prospectAppraisal->currency = $currency;
        $prospectAppraisalMapper->create( $prospectAppraisal );

        return $prospectAppraisal;
    }

    public function getAll()
    {
        $prospectAppraisalMapper = new \Model\Mappers\ProspectAppraisalMapper( $this->container );
        $prospectAppraisals = $prospectAppraisalMapper->mapAll();

        return $prospectAppraisals;
    }

    public function getByID( $id )
    {
        $prospectAppraisal = new \Model\ProspectAppraisal();
        $prospectAppraisalMapper = new \Model\Mappers\ProspectAppraisalMapper( $this->container );
        $prospectAppraisals = $prospectAppraisalMapper->mapFromID( $prospectAppraisal, $id );

        return $prospectAppraisal;
    }

    public function getByProspectID( $prospect_id )
    {
        $prospectAppraisal = new \Model\ProspectAppraisal();
        $prospectAppraisalMapper = new \Model\Mappers\ProspectAppraisalMapper( $this->container );
        $prospectAppraisals = $prospectAppraisalMapper->mapFromProspectID( $prospectAppraisal, $prospect_id );

        return $prospectAppraisals;
    }
}
