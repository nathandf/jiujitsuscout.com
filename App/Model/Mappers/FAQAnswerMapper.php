<?php

namespace Model\Mappers;

class FAQAnswerMapper extends DataMapper
{
    public function create( \Model\FAQAnswer $faqAnswer )
    {
        $id = $this->insert(
            "faq_answer",
            [ "business_id", "faq_id", "text" ],
            [ $faqAnswer->business_id, $faqAnswer->faq_id, $faqAnswer->text ]
        );

        $faqAnswer->id = $id;

        return $faqAnswer;
    }

    public function mapAll()
    {

        $faqAnswers = [];
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $faqAnswer = $this->entityFactory->build( "FAQAnswer" );
            $this->populate( $faqAnswer, $resp );
            $faqAnswers[] = $faqAnswer;
        }

        return $faqAnswers;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $faqAnswers = [];
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer WHERE business_id = :business_id" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $faqAnswer = $this->entityFactory->build( "FAQAnswer" );
            $this->populate( $faqAnswer, $resp );
            $faqAnswers[] = $faqAnswer;
        }

        return $faqAnswers;
    }

    public function mapFromID( \Model\FAQAnswer $faqAnswer, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $faqAnswer, $resp );

        return $faqAnswer;
    }

    public function mapFromBusinessIDAndFAQID( \Model\FAQAnswer $faqAnswer, $business_id, $faq_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer WHERE business_id = :business_id AND faq_id = :faq_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":faq_id", $faq_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $faqAnswer, $resp );

        return $faqAnswer;
    }

    public function updateByBusinessIDAndFAQID( $business_id, $faq_id, $text )
    {
        $sql = $this->DB->prepare( "UPDATE faq_answer SET text = :text WHERE business_id = :business_id AND faq_id = :faq_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":faq_id", $faq_id );
        $sql->bindParam( ":text", $text );
        $sql->execute();
    }
}
