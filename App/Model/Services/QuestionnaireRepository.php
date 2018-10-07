<?php

namespace Model\Services;

class QuestionnaireRepository extends Service
{
    public function create( $name, $description )
    {
        $questionnaire = new \Model\Questionnaire();
        $questionnaireMapper = new \Model\Mappers\QuestionnaireMapper( $this->container );
        $questionnaire->name = $name;
        $questionnaire->description = $description;
        $questionnaireMapper->create( $questionnaire );

        return $questionnaire;
    }

    public function getAll()
    {
        $questionnaireMapper = new \Model\Mappers\QuestionnaireMapper( $this->container );
        $questionnaires = $questionnaireMapper->mapAll();

        return $questionnaires;
    }

    public function getByID( $id )
    {
        $questionnaire = new \Model\Questionnaire();
        $questionnaireMapper = new \Model\Mappers\QuestionnaireMapper( $this->container );
        $questionnaireMapper->mapFromID( $questionnaire, $id );

        return $questionnaire;
    }
}
