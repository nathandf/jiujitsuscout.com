<?php

namespace Model\Services;

class RespondentQuestionAnswerRepository extends Service
{
    public function create( $respondent_id, $question_id, $question_choice_id, $text = null )
    {
        $respondentQuestionAnswer = new \Model\RespondentQuestionAnswer();
        $respondentQuestionAnswerMapper = new \Model\Mappers\RespondentQuestionAnswerMapper( $this->container );
        $respondentQuestionAnswer->respondent_id = $respondent_id;
        $respondentQuestionAnswer->question_id = $question_id;
        $respondentQuestionAnswer->question_choice_id = $question_choice_id;
        $respondentQuestionAnswer->text = $text;
        $respondentQuestionAnswerMapper->create( $respondentQuestionAnswer );

        return $respondentQuestionAnswer;
    }

    public function getAll()
    {
        $respondentQuestionAnswerMapper = new \Model\Mappers\RespondentQuestionAnswerMapper( $this->container );
        $respondentQuestionAnswers = $respondentQuestionAnswerMapper->mapAll();

        return $respondentQuestionAnswers;
    }

    public function getByID( $id )
    {
        $respondentQuestionAnswer = new \Model\RespondentQuestionAnswer();
        $respondentQuestionAnswerMapper = new \Model\Mappers\RespondentQuestionAnswerMapper( $this->container );
        $respondentQuestionAnswerMapper->mapFromID( $respondentQuestionAnswer, $id );

        return $respondentQuestionAnswer;
    }

    public function getByQuestionID( $question_id )
    {
        $respondentQuestionAnswer = new \Model\RespondentQuestionAnswer();
        $respondentQuestionAnswerMapper = new \Model\Mappers\RespondentQuestionAnswerMapper( $this->container );
        $respondentQuestionAnswerMapper->mapFromQuestionID( $respondentQuestionAnswer, $question_id );

        return $respondentQuestionAnswer;
    }

    public function getByQuestionChoiceID( $question_choice_id )
    {
        $respondentQuestionAnswer = new \Model\RespondentQuestionAnswer();
        $respondentQuestionAnswerMapper = new \Model\Mappers\RespondentQuestionAnswerMapper( $this->container );
        $respondentQuestionAnswerMapper->mapFromQuestionID( $respondentQuestionAnswer, $question_choice_id );

        return $respondentQuestionAnswer;
    }
}
