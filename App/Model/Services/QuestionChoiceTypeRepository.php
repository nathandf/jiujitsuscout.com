<?php

namespace Model\Services;

class QuestionChoiceTypeRepository extends Service
{
    public function create( $name, $description )
    {
        $questionChoiceType = new \Model\QuestionChoiceType();
        $questionChoiceTypeMapper = new \Model\Mappers\QuestionChoiceTypeMapper( $this->container );
        $questionChoiceType->name = $name;
        $questionChoiceType->description = $description;
        $questionChoiceTypeMapper->create( $questionChoiceType );

        return $questionChoiceType;
    }

    public function getAll()
    {
        $questionChoiceTypeMapper = new \Model\Mappers\QuestionChoiceTypeMapper( $this->container );
        $questionChoiceTypes = $questionChoiceTypeMapper->mapAll();

        return $questionChoiceTypes;
    }

    public function getByID( $id )
    {
        $questionChoiceType = new \Model\QuestionChoiceType();
        $questionChoiceTypeMapper = new \Model\Mappers\QuestionChoiceTypeMapper( $this->container );
        $questionChoiceTypeMapper->mapFromID( $questionChoiceType, $id );

        return $questionChoiceType;
    }
}
