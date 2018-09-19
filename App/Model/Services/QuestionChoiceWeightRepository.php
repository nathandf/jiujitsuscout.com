<?php

namespace Model\Services;

class QuestionChoiceWeightRepository extends Service
{
    public function create( $question_choice_id, $weight )
    {
        $questionChoiceWeight = new \Model\QuestionChoiceWeight();
        $questionChoiceWeightMapper = new \Model\Mappers\QuestionChoiceWeightMapper( $this->container );
        $questionChoiceWeight->question_choice_id = $question_choice_id;
        $questionChoiceWeight->weight = $weight;
        $questionChoiceWeightMapper->create( $questionChoiceWeight );

        return $questionChoiceWeight;
    }

    public function getAll()
    {
        $questionChoiceWeightMapper = new \Model\Mappers\QuestionChoiceWeightMapper( $this->container );
        $questionChoiceWeights = $questionChoiceWeightMapper->mapAll();

        return $questionChoiceWeights;
    }

    public function getByID( $id )
    {
        $questionChoiceWeight = new \Model\QuestionChoiceWeight();
        $questionChoiceWeightMapper = new \Model\Mappers\QuestionChoiceWeightMapper( $this->container );
        $questionChoiceWeightMapper->mapFromID( $questionChoiceWeight, $id );

        return $questionChoiceWeight;
    }

    public function getByQuestionChoiceID( $question_choice_id )
    {
        $questionChoiceWeight = new \Model\QuestionChoiceWeight();
        $questionChoiceWeightMapper = new \Model\Mappers\QuestionChoiceWeightMapper( $this->container );
        $questionChoiceWeightMapper->mapFromID( $questionChoiceWeight, $question_choice_id );

        return $questionChoiceWeight;
    }

}
