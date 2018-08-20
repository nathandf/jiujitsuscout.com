<?php

namespace Model\Services;

class QuestionChoiceRepository extends Service
{
    public function create( $question_choice_type_id, $question_id, $text )
    {
        $questionChoice = new \Model\QuestionChoice();
        $questionChoiceMapper = new \Model\Mappers\QuestionChoiceMapper( $this->container );
        $questionChoice->question_choice_type_id = $question_choice_type_id;
        $questionChoice->question_id = $question_id;
        $questionChoice->text = $text;
        $questionChoiceMapper->create( $questionChoice );

        return $questionChoice;
    }

    public function getAll()
    {
        $questionChoiceMapper = new \Model\Mappers\QuestionChoiceMapper( $this->container );
        $questionChoices = $questionChoiceMapper->mapAll();

        return $questionChoices;
    }

    public function getByID( $id )
    {
        $questionChoice = new \Model\QuestionChoice();
        $questionChoiceMapper = new \Model\Mappers\QuestionChoiceMapper( $this->container );
        $questionChoiceMapper->mapFromID( $questionChoice, $id );

        return $questionChoice;
    }

    public function getByQuestionID( $question_id )
    {
        $questionChoice = new \Model\QuestionChoice();
        $questionChoiceMapper = new \Model\Mappers\QuestionChoiceMapper( $this->container );
        $questionChoiceMapper->mapFromQuestionID( $questionChoice, $question_id );

        return $questionChoice;
    }
}
