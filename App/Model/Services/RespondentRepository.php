<?php

namespace Model\Services;

class RespondentRepository extends Repository
{
    public function create( $questionnaire_id, $token )
    {
        $mapper = $this->getMapper();
        $respondent = $mapper->build( $this->entityName );
        $respondent->questionnaire_id = $questionnaire_id;
        $respondent->token = $token;
        $mapper->create( $respondent );

        return $respondent;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $respondents = $mapper->mapAll();

        return $respondents;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $respondent = $mapper->build( $this->entityName );
        $mapper->mapFromID( $respondent, $id );

        return $respondent;
    }

    public function getByProspectID( $prospect_id )
    {
        $mapper = $this->getMapper();
        $respondent = $mapper->build( $this->entityName );
        $mapper->mapFromProspectID( $respondent, $prospect_id );

        return $respondent;
    }

    public function getByQuestionnaireID( $questionnaire_id )
    {
        $mapper = $this->getMapper();
        $respondent = $mapper->build( $this->entityName );
        $mapper->mapFromQuestionnaireID( $respondent, $questionnaire_id );

        return $respondent;
    }

    public function getByToken( $token )
    {
        $mapper = $this->getMapper();
        $respondent = $mapper->build( $this->entityName );
        $mapper->mapFromToken( $respondent, $token );

        return $respondent;
    }

    public function updateLastQuestionIDByID( $id, $question_id )
    {
        $mapper = $this->getMapper();
        $mapper->updateLastQuestionIDByID( $id, $question_id );
    }

    public function updateProspectIDByID( $id, $prospect_id )
    {
        $mapper = $this->getMapper();
        $mapper->updateProspectIDByID( $id, $prospect_id );
    }

    public function markQuestionnaireCompleteByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateQuestionnaireCompleteByID( $id, 1 );
    }
}
