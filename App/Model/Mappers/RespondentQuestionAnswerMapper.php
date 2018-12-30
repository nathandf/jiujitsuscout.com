<?php

namespace Model\Mappers;

class RespondentQuestionAnswerMapper extends DataMapper
{
    public function create( \Model\RespondentQuestionAnswer $respondentQuestionAnswer )
    {
        $id = $this->insert(
            "respondent_question_answer",
            [ "respondent_id", "question_id", "question_choice_id", "text" ],
            [ $respondentQuestionAnswer->respondent_id, $respondentQuestionAnswer->question_id, $respondentQuestionAnswer->question_choice_id, $respondentQuestionAnswer->text ]
        );

        $respondentQuestionAnswer->id = $id;

        return $respondentQuestionAnswer;
    }

    public function mapAll()
    {

        $respondentQuestionAnswers = [];
        $sql = $this->DB->prepare( "SELECT * FROM respondent_question_answer" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $respondentQuestionAnswer = $this->entityFactory->build( "RespondentQuestionAnswer" );
            $this->populate( $respondentQuestionAnswer, $resp );
            $respondentQuestionAnswers[] = $respondentQuestionAnswer;
        }

        return $respondentQuestionAnswers;
    }

    public function mapAllFromRespondentID( $respondent_id )
    {

        $respondentQuestionAnswers = [];
        $sql = $this->DB->prepare( "SELECT * FROM respondent_question_answer WHERE respondent_id = :respondent_id" );
        $sql->bindParam( "respondent_id", $respondent_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $respondentQuestionAnswer = $this->entityFactory->build( "RespondentQuestionAnswer" );
            $this->populate( $respondentQuestionAnswer, $resp );
            $respondentQuestionAnswers[] = $respondentQuestionAnswer;
        }

        return $respondentQuestionAnswers;
    }

    public function mapFromID( \Model\RespondentQuestionAnswer $respondentQuestionAnswer, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent_question_answer WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondentQuestionAnswer, $resp );

        return $respondentQuestionAnswer;
    }

    public function mapFromQuestionID( \Model\RespondentQuestionAnswer $respondentQuestionAnswer, $question_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent_question_answer WHERE question_id = :question_id" );
        $sql->bindParam( ":question_id", $question_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondentQuestionAnswer, $resp );

        return $respondentQuestionAnswer;
    }

    public function mapFromQuestionChoiceID( \Model\RespondentQuestionAnswer $respondentQuestionAnswer, $question_choice_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM respondent_question_answer WHERE question_choice_id = :question_choice_id" );
        $sql->bindParam( ":question_choice_id", $question_choice_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $respondentQuestionAnswer, $resp );

        return $respondentQuestionAnswer;
    }
}
