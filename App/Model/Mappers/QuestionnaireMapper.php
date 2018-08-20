<?php

namespace Model\Mappers;

class QuestionnaireMapper extends DataMapper
{

    public function create( \Model\Questionnaire $questionnaire )
    {
        $id = $this->insert(
            "questionnaire",
            [ "name", "description" ],
            [ $questionnaire->name, $questionnaire->description ]
        );

        $questionnaire->id = $id;

        return $questionnaire;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $questionnaires = [];
        $sql = $this->DB->prepare( "SELECT * FROM questionnaire" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $questionnaire = $entityFactory->build( "Questionnaire" );
            $this->populateQuestionnaire( $questionnaire, $resp );
            $questionnaires[] = $questionnaire;
        }

        return $questionnaires;
    }

    public function mapFromID( \Model\Questionnaire $questionnaire, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM questionnaire WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateQuestionnaire( $questionnaire, $resp );

        return $questionnaire;
    }

    private function populateQuestionnaire( \Model\Questionnaire $questionnaire, $data )
    {
        $questionnaire->id          = $data[ "id" ];
        $questionnaire->name        = $data[ "name" ];
        $questionnaire->description = $data[ "description" ];
    }

}
