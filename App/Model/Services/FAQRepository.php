<?php

namespace Model\Services;

class FAQRepository extends Service
{

    public function create( $text, $placement )
    {
        $faq = new \Model\FAQ();
        $faq->placement = $placement;
        $faq->text = $text;
        $faqMapper = new \Model\Mappers\FAQMapper( $this->container );
        $faqMapper->create( $faq );

        return $faq;
    }

    public function getAll()
    {
        $faqMapper = new \Model\Mappers\FAQMapper( $this->container );
        $faqs = $faqMapper->mapAll();
        return $faqs;
    }

    public function getByID( $id )
    {
        $faq = new \Model\FAQ();
        $faqMapper = new \Model\Mappers\FAQMapper( $this->container );
        $faqMapper->mapFromID( $faq, $id );

        return $faq;
    }

}
