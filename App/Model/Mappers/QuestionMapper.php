<?php

namespace Model\Mappers;

class QuestionMapper extends DataMapper
{

    public function create( \Model\Question $question )
    {
        $id = $this->insert(
            "question",
            [ "questionnaire_id", "placement", "text" ],
            [ $question->questionnaire_id, $question->placement, $question->text ]
        );

        $question->id = $id;

        return $question;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $questions = [];
        $sql = $this->DB->prepare( "SELECT * FROM question" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $question = $entityFactory->build( "Question" );
            $this->populateQuestion( $question, $resp );
            $questions[] = $question;
        }

        return $questions;
    }

    public function mapFromID( \Model\Question $question, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestion( $question, $resp );

        return $question;
    }

    public function mapFromQuestionnaireID( \Model\Question $question, $questionnaire_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question WHERE questionnaire_id = :questionnaire_id" );
        $sql->bindParam( ":questionnaire_id", $questionnaire_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestion( $question, $resp );

        return $question;
    }

    private function populateQuestion( \Model\Question $question, $data )
    {
        $question->id               = $data[ "id" ];
        $question->questionnaire_id = $data[ "questionnaire_id" ];
        $question->placement        = $data[ "placement" ];
        $question->text             = $data[ "text" ];
    }

}
