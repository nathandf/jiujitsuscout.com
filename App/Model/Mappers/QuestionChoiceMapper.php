<?php

namespace Model\Mappers;

class QuestionChoiceMapper extends DataMapper
{

    public function create( \Model\QuestionChoice $questionChoice )
    {
        $id = $this->insert(
            "question_choice",
            [ "question_choice_type_id", "question_id", "text" ],
            [ $questionChoice->question_choice_type_id, $questionChoice->question_id, $questionChoice->text ]
        );

        $questionChoice->id = $id;

        return $questionChoice;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $questionChoices = [];
        $sql = $this->DB->prepare( "SELECT * FROM question_choice" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $questionChoice = $entityFactory->build( "QuestionChoice" );
            $this->populateQuestion( $questionChoice, $resp );
            $questionChoices[] = $questionChoice;
        }

        return $questionChoices;
    }

    public function mapFromID( \Model\QuestionChoice $questionChoice, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question_choice WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestion( $questionChoice, $resp );

        return $questionChoice;
    }

    public function mapFromQuestionID( \Model\QuestionChoice $questionChoice, $question_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question_choice WHERE question_id = :question_id" );
        $sql->bindParam( ":question_id", $question_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestion( $questionChoice, $resp );

        return $questionChoice;
    }

    private function populateQuestionChoice( \Model\QuestionChoice $questionChoice, $data )
    {
        $questionChoice->id                      = $data[ "id" ];
        $questionChoice->question_choice_type_id = $data[ "question_choice_type_id" ];
        $questionChoice->question_id             = $data[ "question_id" ];
        $questionChoice->text                    = $data[ "text" ];
    }

}
