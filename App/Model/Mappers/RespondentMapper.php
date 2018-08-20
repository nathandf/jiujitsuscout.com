<?php

namespace Model\Mappers;

class RespondentMapper extends DataMapper
{

    public function create( \Model\Respondent $respondent )
    {
        $id = $this->insert(
            "question",
            [ "questionnaire_id", "last_question_id", "token" ],
            [ $respondent->questionnaire_id, $respondent->last_question_id, $respondent->token ]
        );

        $respondent->id = $id;

        return $respondent;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $respondents = [];
        $sql = $this->DB->prepare( "SELECT * FROM respondent" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $respondent = $entityFactory->build( "Respondent" );
            $this->populateRespondent( $respondent, $resp );
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
        $this->populateRespondent( $respondent, $resp );

        return $respondent;
    }

    public function mapFromQuestionnaireID( \Model\Respondent $respondent, $questionnaire_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE questionnaire_id = :questionnaire_id" );
        $sql->bindParam( ":questionnaire_id", $questionnaire_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateRespondent( $respondent, $resp );

        return $respondent;
    }

    public function mapFromToken( \Model\Respondent $respondent, $token )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE token = :token" );
        $sql->bindParam( ":token", $token );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateRespondent( $respondent, $resp );

        return $respondent;
    }

    private function populateRespondent( \Model\Respondent $respondent, $data )
    {
        $respondent->id                      = $data[ "id" ];
        $respondent->questionnaire_id        = $data[ "questionnaire_id" ];
        $respondent->questionnaire_completed = $data[ "questionnaire_completed" ];
        $respondent->last_question_id        = $data[ "last_question_id" ];
        $respondent->prospect_id             = $data[ "prospect_id" ];
        $respondent->token                   = $data[ "token" ];
    }

}
