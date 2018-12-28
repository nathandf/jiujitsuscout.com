<?php

namespace Model\Services;

class RespondentQuestionAnswerRepository extends Repository
{
    public function create( $respondent_id, $question_id, $question_choice_id, $text = null )
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswer = $mapper->build( $this->entityName );
        $respondentQuestionAnswer->respondent_id = $respondent_id;
        $respondentQuestionAnswer->question_id = $question_id;
        $respondentQuestionAnswer->question_choice_id = $question_choice_id;
        $respondentQuestionAnswer->text = $text;
        $mapper->create( $respondentQuestionAnswer );

        return $respondentQuestionAnswer;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswers = $mapper->mapAll();

        return $respondentQuestionAnswers;
    }

    public function getAllByRespondentID( $respondent_id )
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswers = $mapper->mapAllFromRespondentID( $respondent_id );

        return $respondentQuestionAnswers;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswer = $mapper->build( $this->entityName );
        $mapper->mapFromID( $respondentQuestionAnswer, $id );

        return $respondentQuestionAnswer;
    }

    public function getByQuestionID( $question_id )
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswer = $mapper->build( $this->entityName );
        $mapper->mapFromQuestionID( $respondentQuestionAnswer, $question_id );

        return $respondentQuestionAnswer;
    }

    public function getByQuestionChoiceID( $question_choice_id )
    {
        $mapper = $this->getMapper();
        $respondentQuestionAnswer = $mapper->build( $this->entityName );
        $mapper->mapFromQuestionID( $respondentQuestionAnswer, $question_choice_id );

        return $respondentQuestionAnswer;
    }
}
