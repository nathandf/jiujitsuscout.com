<?php

namespace Model\Services;

class ProspectRegistrar
{
    public function __construct( ProspectRepository $repo, EntityFactory $factory )
    {
        $this->repo = $repo;
        $this->factory = $factory;
    }

    public function register( \Model\Prospect $prospect )
    {
        $id = $this->repo->save( $prospect );
        $prospect->id = $id;
        $this->setProspect( $prospect );
    }

    public function add( array $properties )
    {
        $prospect = $this->factory->build( "Prospect" );
        $this->setProperties( $prospect, $properties );
        $id = $this->repo->save( $prospect );
        $prospect->id = $id;
        $this->setProspect( $prospect );
    }

    public function build()
    {
        $prospect = $this->factory->build( "Prospect" );

        return $prospect;
    }

    private function setProspect( $prospect )
    {
        $this->prospect = $prospect;
    }

    public function getProspect()
    {
        if ( isset( $this->prospect ) ) {
            return $this->repo->getByID( $this->prospect->id );
        }

        return null;
    }

    protected function setProperties( \Model\Prospect $prospect, array $properties )
    {
        foreach ( $properties as $property => $property_value ) {
            $prospect->{$property} = $property_value;
        }
    }
}
