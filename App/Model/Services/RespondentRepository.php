<?php

namespace Model\Services;

class RespondentRepository extends Service
{
    public function create( $questionnaire_id, $token )
    {
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondent->questionnaire_id = $questionnaire_id;
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

    public function getByProspectID( $prospect_id )
    {
        $respondent = new \Model\Respondent();
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->mapFromProspectID( $respondent, $prospect_id );

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

    public function updateLastQuestionIDByID( $id, $question_id )
    {
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->updateLastQuestionIDByID( $id, $question_id );
    }

    public function updateProspectIDByID( $id, $prospect_id )
    {
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->updateProspectIDByID( $id, $prospect_id );
    }

    public function markQuestionnaireCompleteByID( $id )
    {
        $respondentMapper = new \Model\Mappers\RespondentMapper( $this->container );
        $respondentMapper->updateQuestionnaireCompleteByID( $id, 1 );
    }
}
