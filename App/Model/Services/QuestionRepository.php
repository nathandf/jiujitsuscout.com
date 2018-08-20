<?php

namespace Model\Services;

class QuestionRepository extends Service
{
    public function create( $questionnaire_id, $placement, $text )
    {
        $question = new \Model\Question();
        $questionMapper = new \Model\Mappers\QuestionMapper( $this->container );
        $question->questionnaire_id = $questionnaire_id;
        $question->placement = $placement;
        $question->text = $text;
        $questionMapper->create( $question );

        return $question;
    }

    public function getAll()
    {
        $questionMapper = new \Model\Mappers\QuestionMapper( $this->container );
        $questions = $questionMapper->mapAll();

        return $questions;
    }

    public function getByID( $id )
    {
        $question = new \Model\Question();
        $questionMapper = new \Model\Mappers\QuestionMapper( $this->container );
        $questionMapper->mapFromID( $question, $id );

        return $question;
    }

    public function getByQuestionnaireID( $questionnaire_id )
    {
        $question = new \Model\Question();
        $questionMapper = new \Model\Mappers\QuestionMapper( $this->container );
        $questionMapper->mapFromQuestionnaireID( $question, $questionnaire_id );

        return $question;
    }
}
