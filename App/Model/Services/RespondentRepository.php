<?php

namespace Model\Services;

class RespondentRepository extends Service
{
    public function create( $questionnaire_id, $last_question_id )
    {
        $token = md5( $questionnaire_id . microtime() );
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondent->questionnaire_id = $questionnaire_id;
        $respondent->last_question_id = $last_question_id;
        $respondent->token = $token;
        $respondentMapper->create( $respondent );

        return $respondent;
    }

    public function getAll()
    {
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondents = $respondentMapper->mapAll();

        return $respondents;
    }

    public function getByID( $id )
    {
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->mapFromID( $respondent, $id );

        return $respondent;
    }

    public function getByQuestionnaireID( $questionnaire_id )
    {
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->mapFromQuestionnaireID( $respondent, $questionnaire_id );

        return $respondent;
    }

    public function getByToken( $token )
    {
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->mapFromToken( $respondent, $token );

        return $respondent;
    }
}
