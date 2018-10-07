<?php

namespace Model\Services;

class FAQAnswerRepository extends Service
{

    public function create( $business_id, $faq_id, $text )
    {
        $faqAnswer = new \Model\FAQAnswer();
        $faqAnswer->business_id = $business_id;
        $faqAnswer->text = $text;
        $faqAnswer->faq_id = $faq_id;
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswerMapper->create( $faqAnswer );

        return $faqAnswer;
    }

    public function getAll()
    {
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswers = $faqAnswerMapper->mapAll();
        return $faqAnswers;
    }

    public function getByID( $id )
    {
        $faqAnswer = new \Model\FAQAnswer();
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswerMapper->mapFromID( $faqAnswer, $id );

        return $faqAnswer;
    }

    public function getAllByBusinessID( $business_id )
    {
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswers = $faqAnswerMapper->mapAllFromBusinessID( $business_id );
        return $faqAnswers;
    }

    public function getByBusinessIDAndFAQID( $business_id, $faq_id )
    {
        $faqAnswer = new \Model\FAQAnswer();
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswerMapper->mapFromBusinessIDAndFAQID( $faqAnswer, $business_id, $faq_id );

        return $faqAnswer;
    }

    public function updateByBusinessIDAndFAQID( $business_id, $faq_id, $text )
    {
        $faqAnswerMapper = new \Model\Mappers\FAQAnswerMapper( $this->container );
        $faqAnswerMapper->updateByBusinessIDAndFAQID( $business_id, $faq_id, $text );
    }

}
