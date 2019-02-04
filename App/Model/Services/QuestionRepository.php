<?php

namespace Model\Services;

class QuestionRepository extends Repository
{
    public function create( $questionnaire_id, $placement, $text )
    {
        $mapper = $this->getMapper();
        $question = $mapper->build( $this->entityName );
        $question->questionnaire_id = $questionnaire_id;
        $question->placement = $placement;
        $question->text = $text;
        $mapper->create( $question );

        return $question;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $questions = $mapper->mapAll();

        return $questions;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $question = $mapper->build( $this->entityName );
        $mapper->mapFromID( $question, $id );

        return $question;
    }

    public function getAllByQuestionnaireID( $questionnaire_id )
    {
        $mapper = $this->getMapper();
        $questions = $mapper->mapAllFromQuestionnaireID( $questionnaire_id );

        return $questions;
    }
}
