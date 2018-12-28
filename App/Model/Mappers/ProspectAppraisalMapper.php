<?php

namespace Model\Mappers;

use Model\ProspectAppraisal;

class ProspectAppraisalMapper extends DataMapper
{

    public function create( \Model\ProspectAppraisal $prospectAppraisal )
    {
        $id = $this->insert(
            "prospect_appraisal",
            [ "prospect_id", "value", "currency" ],
            [ $prospectAppraisal->prospect_id, $prospectAppraisal->value, $prospectAppraisal->currency ]
        );
        $prospectAppraisal->id = $id;
        
        return $prospectAppraisal;
    }

    public function mapFromID( ProspectAppraisal $prospectAppraisal, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM prospect_appraisal WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateProspectAppraisal( $prospectAppraisal, $resp );

        return $prospectAppraisal;
    }

    public function mapFromProspectID( ProspectAppraisal $prospectAppraisal, $prospect_id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM prospect_appraisal WHERE prospect_id = :prospect_id' );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateProspectAppraisal( $prospectAppraisal, $resp );

        return $prospectAppraisal;
    }

    public function mapAll()
    {
        
        $prospectAppraisals = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect_appraisal" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospectAppraisal = $this->entityFactory->build( "ProspectAppraisal" );
            $this->populateProspectAppraisal( $prospectAppraisal, $resp );
            $prospectAppraisals[] = $prospectAppraisal;
        }

        return $prospectAppraisals;
    }

    private function populateProspectAppraisal( \Model\ProspectAppraisal $prospectAppraisal, $data )
    {
        $prospectAppraisal->id = $data[ "id" ];
        $prospectAppraisal->prospect_id = $data[ "prospect_id" ];
        $prospectAppraisal->value = $data[ "value" ];
        $prospectAppraisal->currency = $data[ "currency" ];
    }

}
