<?php

namespace Model\Services;

class FAQAnswerRepository extends Repository
{

    public function create( $business_id, $faq_id, $text )
    {
        $mapper = $this->getMapper();
        $faqAnswer = $mapper->build( $this->entityName );
        $faqAnswer->business_id = $business_id;
        $faqAnswer->text = $text;
        $faqAnswer->faq_id = $faq_id;
        $mapper->create( $faqAnswer );

        return $faqAnswer;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $faqAnswers = $mapper->mapAll();
        return $faqAnswers;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $faqAnswer = $mapper->build( $this->entityName );
        $mapper->mapFromID( $faqAnswer, $id );

        return $faqAnswer;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $faqAnswers = $mapper->mapAllFromBusinessID( $business_id );
        return $faqAnswers;
    }

    public function getByBusinessIDAndFAQID( $business_id, $faq_id )
    {
        $mapper = $this->getMapper();
        $faqAnswer = $mapper->build( $this->entityName );
        $mapper->mapFromBusinessIDAndFAQID( $faqAnswer, $business_id, $faq_id );

        return $faqAnswer;
    }

    public function updateByBusinessIDAndFAQID( $business_id, $faq_id, $text )
    {
        $mapper = $this->getMapper();
        $mapper->updateByBusinessIDAndFAQID( $business_id, $faq_id, $text );
    }

}
