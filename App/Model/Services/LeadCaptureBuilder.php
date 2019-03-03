<?php

namespace Model\Services;

use Model\Services\LeadCaptureRepository;
use Model\Services\LandingPageLeadCaptureRepository;
use Model\Services\EmbeddableFormLeadCaptureRepository;
use Model\Services\ProfileLeadCaptureRepository;


/**
* Class SequenceManager
*
* @package Model\Services
*
* @property \Model\Services\LeadCaptureRepository
* @property \Model\Services\LandingPageLeadCaptureRepository
* @property \Model\Services\EmbeddableFormLeadCaptureRepository
* @property \Model\Services\ProfileLeadCaptureRepository
*/

class LeadCaptureBuilder
{
    private $business_id = null;
    private $prospect_id = null;
    private $landing_page_id = null;
    private $embeddable_form_id = null;
    private $is_profile = false;
    private $error_messages = [];

    public function __construct(
        LeadCaptureRepository $leadCaptureRepo,
        LandingPageLeadCaptureRepository $landingPageLeadCaptureRepo,
        EmbeddableFormLeadCaptureRepository $embeddableFormLeadCaptureRepo,
        ProfileLeadCaptureRepository $profileLeadCaptureRepo
    ) {
        $this->leadCaptureRepo = $leadCaptureRepo;
        $this->landingPageLeadCaptureRepo = $landingPageLeadCaptureRepo;
        $this->embeddableFormLeadCaptureRepo = $embeddableFormLeadCaptureRepo;
        $this->profileLeadCaptureRepo = $profileLeadCaptureRepo;
    }

    private function addErrorMessage( $message )
    {
        $this->error_messages[] = $message;
    }

    public function getErrorMessages()
    {
        return $this->error_messages;
    }

    public function setBusinessID( $business_id )
    {
        $this->business_id = $business_id;
        return $this;
    }

    public function setProspectID( $prospect_id )
    {
        $this->prospect_id = $prospect_id;
        return $this;
    }

    public function setLandingPageID( $landing_page_id )
    {
        $this->landing_page_id = $landing_page_id;
        return $this;
    }

    public function setEmbeddableFormID( $embeddable_form_id )
    {
        $this->embeddable_form_id = $embeddable_form_id;
        return $this;
    }

    public function isProfile()
    {
        $this->is_profile = true;
        return $this;
    }

    public function build()
    {
        $leadCapture = $this->leadCaptureRepo->insert([
            "prospect_id" => $this->prospect_id
        ]);

        if ( $this->is_profile && !is_null( $this->business_id ) ) {
            $this->profileLeadCaptureRepo->insert([
                "lead_capture_id" => $leadCapture->id,
                "business_id" => $this->business_id
            ]);
        }

        if ( !is_null( $this->landing_page_id ) ) {
            $this->landingPageLeadCaptureRepo->insert([
                "lead_capture_id" => $leadCapture->id,
                "landing_page_id" => $this->landing_page_id
            ]);
        }

        if ( !is_null( $this->embeddable_form_id ) ) {
            $this->embeddableFormLeadCaptureRepo->insert([
                "lead_capture_id" => $leadCapture->id,
                "embeddable_form_id" => $this->embeddable_form_id
            ]);
        }

        // If requried contact information is no available, return false
        if ( !empty( $this->getErrorMessages() ) ) {
            return false;
        }

        return true;
    }
}
