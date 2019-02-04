<?php

namespace Model\Mappers;

class RespondentMapper extends DataMapper
{
    public function create( \Model\Respondent $respondent )
    {
        $id = $this->insert(
            "respondent",
            [ "questionnaire_id", "token" ],
            [ $respondent->questionnaire_id, $respondent->token ]
        );

        $respondent->id = $id;

        return $respondent;
    }

    public function mapAll()
    {

        $respondents = [];
        $sql = $this->DB->prepare( "SELECT * FROM respondent" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $respondent = $this->entityFactory->build( "Respondent" );
            $this->populate( $respondent, $resp );
            $respondents[] = $respondent;
        }

        return $respondents;
    }

    public function mapFromID( \Model\Respondent $respondent, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondent, $resp );

        return $respondent;
    }

    public function mapFromProspectID( \Model\Respondent $respondent, $prospect_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE prospect_id = :prospect_id" );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondent, $resp );

        return $respondent;
    }

    public function mapFromQuestionnaireID( \Model\Respondent $respondent, $questionnaire_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE questionnaire_id = :questionnaire_id" );
        $sql->bindParam( ":questionnaire_id", $questionnaire_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondent, $resp );

        return $respondent;
    }

    public function mapFromToken( \Model\Respondent $respondent, $token )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE token = :token" );
        $sql->bindParam( ":token", $token );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondent, $resp );

        return $respondent;
    }

    public function updateLastQuestionIDByID( $id, $question_id )
    {
        $this->update( "respondent", "last_question_id", $question_id, "id", $id );
    }

    public function updateProspectIDByID( $id, $prospect_id )
    {
        $this->update( "respondent", "prospect_id", $prospect_id, "id", $id );
    }

    public function updateQuestionnaireCompleteByID( $id, $value )
    {
        $this->update( "respondent", "questionnaire_complete", $value, "id", $id );
    }
}
