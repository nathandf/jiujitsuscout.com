<?php

namespace Model\Services;

class ProspectAppraisalRepository extends Repository
{
    public function create( $prospect_id, $value, $currency = "USD" )
    {
        $mapper = $this->getMapper();
        $prospectAppraisal = $mapper->build( $this->entityName );
        $prospectAppraisal->prospect_id = $prospect_id;
        $prospectAppraisal->value = $value;
        $prospectAppraisal->currency = $currency;
        $mapper->create( $prospectAppraisal );

        return $prospectAppraisal;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $prospectAppraisals = $mapper->mapAll();

        return $prospectAppraisals;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $prospectAppraisal = $mapper->build( $this->entityName );
        $prospectAppraisals = $mapper->mapFromID( $prospectAppraisal, $id );

        return $prospectAppraisal;
    }

    public function getByProspectID( $prospect_id )
    {
        $mapper = $this->getMapper();
        $prospectAppraisal = $mapper->build( $this->entityName );
        $prospectAppraisals = $mapper->mapFromProspectID( $prospectAppraisal, $prospect_id );

        return $prospectAppraisals;
    }
}
