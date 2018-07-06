<?php

namespace Models\Services;

class LandingPageTemplateRepository extends Service
{

  public function getAll()
  {
    $landingPageTemplateMapper = new \Models\Mappers\LandingPageTemplateMapper( $this->container );
    $landingPageTemplates = $landingPageTemplateMapper->mapAll();
    return $landingPageTemplates;
  }

  public function getByID( $id )
  {
    $landingPageTemplate = new \Models\LandingPageTemplate();
    $landingPageTemplateMapper = new \Models\Mappers\LandingPageTemplateMapper( $this->container );
    $landingPageTemplateMapper->mapFromID( $landingPageTemplate, $id );

    return $landingPageTemplate;
  }

}
