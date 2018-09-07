<?php

namespace Model\Mappers;

class QuestionChoiceTypeMapper extends DataMapper
{

    public function create( \Model\QuestionChoiceType $question_choice_type )
    {
        $id = $this->insert(
            "question_choice_type",
            [ "name", "description" ],
            [ $question_choice_type->name, $question_choice_type->description ]
        );

        $question_choice_type->id = $id;

        return $question_choice_type;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $question_choice_types = [];
        $sql = $this->DB->prepare( "SELECT * FROM question_choice_type" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $question_choice_type = $entityFactory->build( "QuestionChoiceType" );
            $this->populateQuestionChoiceType( $question_choice_type, $resp );
            $question_choice_types[] = $question_choice_type;
        }

        return $question_choice_types;
    }

    public function mapFromID( \Model\QuestionChoiceType $question_choice_type, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM question_choice_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestionChoiceType( $question_choice_type, $resp );

        return $question_choice_type;
    }

    private function populateQuestionChoiceType( \Model\QuestionChoiceType $question_choice_type, $data )
    {
        $question_choice_type->id          = $data[ "id" ];
        $question_choice_type->name        = $data[ "name" ];
        $question_choice_type->description = $data[ "description" ];
    }

}
