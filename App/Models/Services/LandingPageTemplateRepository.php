<?php

namespace Model\Services;

class LandingPageTemplateRepository extends Service
{

  public function getAll()
  {
    $landingPageTemplateMapper = new \Model\Mappers\LandingPageTemplateMapper( $this->container );
    $landingPageTemplates = $landingPageTemplateMapper->mapAll();
    return $landingPageTemplates;
  }

  public function getByID( $id )
  {
    $landingPageTemplate = new \Model\LandingPageTemplate();
    $landingPageTemplateMapper = new \Model\Mappers\LandingPageTemplateMapper( $this->container );
    $landingPageTemplateMapper->mapFromID( $landingPageTemplate, $id );

    return $landingPageTemplate;
  }

}
