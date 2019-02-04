<?php

namespace Model\Services;

class QuestionChoiceTypeRepository extends Repository
{
    public function create( $name, $description )
    {
        $mapper = $this->getMapper();
        $questionChoiceType = $mapper->build( $this->entityName );
        $questionChoiceType->name = $name;
        $questionChoiceType->description = $description;
        $mapper->create( $questionChoiceType );

        return $questionChoiceType;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $questionChoiceTypes = $mapper->mapAll();

        return $questionChoiceTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $questionChoiceType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $questionChoiceType, $id );

        return $questionChoiceType;
    }
}
