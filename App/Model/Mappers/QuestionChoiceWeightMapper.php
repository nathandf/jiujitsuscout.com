<?php

namespace Model\Mappers;

class QuestionChoiceWeightMapper extends DataMapper
{

    public function create( \Model\QuestionChoiceWeight $questionChoiceWeight )
    {
        $id = $this->insert(
            "question_choice",
            [ "question_choice_id", "weight" ],
            [ $questionChoiceWeight->question_choice_id, $questionChoiceWeight->weight ]
        );

        $questionChoiceWeight->id = $id;

        return $questionChoiceWeight;
    }

    public function mapAll()
    {
        
        $questionChoiceWeights = [];
        $sql = $this->DB->prepare( "SELECT * FROM question_choice" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $questionChoiceWeight = $this->entityFactory->build( "QuestionChoiceWeight" );
            $this->populateQuestionChoiceWeight( $questionChoiceWeight, $resp );
            $questionChoiceWeights[] = $questionChoiceWeight;
        }

        return $questionChoiceWeights;
    }

    public function mapFromID( \Model\QuestionChoiceWeight $questionChoiceWeight, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question_choice_weight WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestionChoiceWeight( $questionChoiceWeight, $resp );

        return $questionChoiceWeight;
    }

    public function mapFromQuestionChoiceID( \Model\QuestionChoiceWeight $questionChoiceWeight, $question_choice_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question_choice_weight WHERE question_choice_id = :question_choice_id" );
        $sql->bindParam( ":question_choice_id", $question_choice_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestionChoiceWeight( $questionChoiceWeight, $resp );

        return $questionChoiceWeight;
    }

    private function populateQuestionChoiceWeight( \Model\QuestionChoiceWeight $questionChoiceWeight, $data )
    {
        $questionChoiceWeight->id                      = $data[ "id" ];
        $questionChoiceWeight->question_choice_id = $data[ "question_choice_id" ];
        $questionChoiceWeight->weight             = $data[ "weight" ];
    }

}
