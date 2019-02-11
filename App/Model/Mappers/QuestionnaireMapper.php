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
        $questionnaires = [];
        $sql = $this->DB->prepare( "SELECT * FROM questionnaire" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $questionnaire = $this->entityFactory->build( "Questionnaire" );
            $this->populate( $questionnaire, $resp );
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
        $this->populate( $questionnaire, $resp );

        return $questionnaire;
    }
}
