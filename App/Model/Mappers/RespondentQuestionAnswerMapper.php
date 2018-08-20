<?php

namespace Model\Mappers;

class RespondentMapper extends DataMapper
{

    public function create( \Model\Respondent $respondent )
    {
        $id = $this->insert(
            "question",
            [ "respondent_id", "question_id", "question_choice_id", "text" ],
            [ $respondent->respondent_id, $respondent->question_id, $respondent->question_choice_id, $respondent->text ]
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
            $this->populateRespondentQuestionAnswer( $respondent, $resp );
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
        $this->populateRespondentQuestionAnswer( $respondent, $resp );

        return $respondent;
    }

    public function mapFromQuestionID( \Model\Respondent $respondent, $question_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE question_id = :question_id" );
        $sql->bindParam( ":question_id", $question_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateRespondentQuestionAnswer( $respondent, $resp );

        return $respondent;
    }

    public function mapFromQuestionChoiceID( \Model\Respondent $respondent, $question_choice_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent WHERE question_choice_id = :question_choice_id" );
        $sql->bindParam( ":question_choice_id", $question_choice_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateRespondentQuestionAnswer( $respondent, $resp );

        return $respondent;
    }

    private function populateRespondentQuestionAnswer( \Model\Respondent $respondent, $data )
    {
        $respondent->id                 = $data[ "id" ];
        $respondent->respondent_id      = $data[ "respondent_id" ];
        $respondent->question_id        = $data[ "question_id" ];
        $respondent->question_choice_id = $data[ "question_choice_id" ];
        $respondent->text               = $data[ "text" ];
    }

}
