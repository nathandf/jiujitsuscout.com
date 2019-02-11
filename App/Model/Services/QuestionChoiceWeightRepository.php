<?php

namespace Model\Services;

class QuestionChoiceWeightRepository extends Repository
{
    public function create( $question_choice_id, $weight )
    {
        $mapper = $this->getMapper();
        $questionChoiceWeight = $mapper->build( $this->entityName );
        $questionChoiceWeight->question_choice_id = $question_choice_id;
        $questionChoiceWeight->weight = $weight;
        $mapper->create( $questionChoiceWeight );

        return $questionChoiceWeight;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $questionChoiceWeights = $mapper->mapAll();

        return $questionChoiceWeights;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $questionChoiceWeight = $mapper->build( $this->entityName );
        $mapper->mapFromID( $questionChoiceWeight, $id );

        return $questionChoiceWeight;
    }

    public function getByQuestionChoiceID( $question_choice_id )
    {
        $mapper = $this->getMapper();
        $questionChoiceWeight = $mapper->build( $this->entityName );
        $mapper->mapFromID( $questionChoiceWeight, $question_choice_id );

        return $questionChoiceWeight;
    }

}
