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
        $entityFactory = $this->container->getService( "entity-factory" );
        $faqAnswers = [];
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $faqAnswer = $entityFactory->build( "FAQAnswer" );
            $this->populateFAQAnswer( $faqAnswer, $resp );
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
        $this->populateFAQAnswer( $faqAnswer, $resp );
        return $faqAnswer;
    }

    public function mapFromBusinessIDAndFAQID( \Model\FAQAnswer $faqAnswer, $business_id, $faq_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM faq_answer WHERE business_id = :business_id AND faq_id = :faq_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":faq_id", $faq_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateFAQAnswer( $faqAnswer, $resp );
        return $faqAnswer;
    }

    private function populateFAQAnswer( \Model\FAQAnswer $faqAnswer, $data )
    {
        $faqAnswer->id = $data[ "id" ];
        $faqAnswer->business_id = $data[ "business_id" ];
        $faqAnswer->faq_id = $data[ "faq_id" ];
        $faqAnswer->text = $data[ "text" ];
    }

}
