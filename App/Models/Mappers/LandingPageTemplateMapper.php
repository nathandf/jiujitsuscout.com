<?php

namespace Model\Mappers;

class LandingPageTemplateMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $landingPageTemplates = [];
    $sql = $this->DB->prepare( "SELECT * FROM landing_page_template" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $landingPageTemplate = $entityFactory->build( "LandingPageTemplate" );
      $this->populateLandingPageTemplate( $landingPageTemplate, $resp );
      $landingPageTemplates[] = $landingPageTemplate;
    }

    return $landingPageTemplates;
  }

  public function mapFromID( \Model\LandingPageTemplate $landingPageTemplate, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM landing_page_template WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateLandingPageTemplate( $landingPageTemplate, $resp );
    return $landingPageTemplate;
  }

  private function populateLandingPageTemplate( \Model\LandingPageTemplate $landingPageTemplate, $data )
  {
    $landingPageTemplate->id                = $data[ "id" ];
    $landingPageTemplate->name              = $data[ "name" ];
    $landingPageTemplate->template_filename = $data[ "template_filename" ];
  }

}
