<?php

namespace Model\Services;

class BusinessRegistrar
{

    public $businessRepo;
    public $groupRepo;
    public $phoneRepo;

    public function __construct( \Model\Services\BusinessRepository $businessRepo, \Model\Services\GroupRepository $groupRepo, \Model\Services\PhoneRepository $phoneRepo )
    {
        $this->setBusinessRepo( $businessRepo );
        $this->setGroupRepo( $groupRepo );
        $this->setPhoneRepo( $phoneRepo );
    }

    private function setBusinessRepo( $businessRepo )
    {
        $this->businessRepo = $businessRepo;
    }

    private function setGroupRepo( $groupRepo )
    {
        $this->groupRepo = $groupRepo;
    }

    private function setPhoneRepo( $phoneRepo )
    {
        $this->phoneRepo = $phoneRepo;
    }

    public function register( $account_id, $business_name, $contact_name, $country_code, $phone_number, $email, $country, $timezone )
    {
        // Create a phone model for this businesses
        $phone = $this->phoneRepo->create( $country_code, $phone_number );

        // Create business
        $business = $this->businessRepo->create( $account_id, $business_name, $contact_name, $phone->id, $email, $country, $timezone );

        // Set business as publically accessible property
        $this->setBusiness( $business );

        // Generate unique landing page slug
        $site_slug = $business->generateSiteSlug( $business->business_name, $business->id );
        $this->businessRepo->updateSiteSlugByID( $business->id, $site_slug );

        // Create 2 default groups, "leads" and "memebers"
        $this->groupRepo->create( $business->id, "Leads", "Default group for leads that sign up for your promotions" );
        $this->groupRepo->create( $business->id, "Members", "Default group for members that you import, add manually, or convert from leads" );
    }

    public function setBusiness( \Model\Business $business )
    {
        $this->business = $business;
    }

    public function getBusiness()
    {
        return $this->business;
    }

}
