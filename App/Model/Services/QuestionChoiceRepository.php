<?php

namespace Model\Services;

class QuestionChoiceRepository extends Repository
{
    public function create( $question_choice_type_id, $question_id, $text )
    {
        $mapper = $this->getMapper();
        $questionChoice = $mapper->build( $this->entityName );
        $questionChoice->question_choice_type_id = $question_choice_type_id;
        $questionChoice->question_id = $question_id;
        $questionChoice->text = $text;
        $mapper->create( $questionChoice );

        return $questionChoice;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $questionChoices = $mapper->mapAll();

        return $questionChoices;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $questionChoice = $mapper->build( $this->entityName );
        $mapper->mapFromID( $questionChoice, $id );

        return $questionChoice;
    }

    public function getAllByQuestionID( $question_id )
    {
        $mapper = $this->getMapper();
        $questionChoices = $mapper->mapAllFromQuestionID( $question_id );

        return $questionChoices;
    }
}
