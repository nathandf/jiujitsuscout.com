<?php

namespace Model\Services;

class LandingPageTemplateRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $landingPageTemplates = $mapper->mapAll();

        return $landingPageTemplates;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $landingPageTemplate = $mapper->build( $this->entityName );
        $mapper->mapFromID( $landingPageTemplate, $id );

        return $landingPageTemplate;
    }
}
