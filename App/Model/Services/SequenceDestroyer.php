<?php

namespace Model\Services;

use \Model\Services\SequenceTemplateSequenceRepository;
use \Model\Services\ProspectSequenceRepository;
use \Model\Services\MemberSequenceRepository;
use \Model\Services\BusinessSequenceRepository;

/**
* Class SequenceDestroyer
*
* @package Model\Services
*
* @property \Model\Services\SequenceTemplateSequenceRepository
* @property \Model\Services\ProspectSequenceRepository
* @property \Model\Services\MemberSequenceRepository
* @property \Model\Services\BusinessSequenceRepository
*/

class SequenceDestroyer
{
    public function __construct(
        SequenceRepository $sequenceRepo,
        SequenceTemplateSequenceRepository $sequenceTemplateSequenceRepo,
        ProspectSequenceRepository $prospectSequenceRepo,
        MemberSequenceRepository $memberSequenceRepo,
        BusinessSequenceRepository $businessSequenceRepo
    ) {
        $this->sequenceRepo = $sequenceRepo;
        $this->sequenceTemplateSequenceRepo = $sequenceTemplateSequenceRepo;
        $this->prospectSequenceRepo = $prospectSequenceRepo;
        $this->memberSequenceRepo = $memberSequenceRepo;
        $this->businessSequenceRepo = $businessSequenceRepo;
    }

    public function destroy( $sequence_id )
    {
        $this->sequenceRepo->delete( [ "id" => $sequence_id ] );
        $this->sequenceTemplateSequenceRepo->delete( [ "sequence_id" => $sequence_id ] );
        $this->prospectSequenceRepo->delete( [ "sequence_id" => $sequence_id ] );
        $this->memberSequenceRepo->delete( [ "sequence_id" => $sequence_id ] );
        $this->businessSequenceRepo->delete( [ "sequence_id" => $sequence_id ] );
    }
}
