<?php

namespace Model\Services;

class QuestionnaireRepository extends Repository
{
    public function create( $name, $description )
    {
        $mapper = $this->getMapper();
        $questionnaire = $mapper->build( $this->entityName );
        $questionnaire->name = $name;
        $questionnaire->description = $description;
        $mapper->create( $questionnaire );

        return $questionnaire;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $questionnaires = $mapper->mapAll();

        return $questionnaires;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $questionnaire = $mapper->build( $this->entityName );
        $mapper->mapFromID( $questionnaire, $id );

        return $questionnaire;
    }
}
