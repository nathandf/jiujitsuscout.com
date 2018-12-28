<?php

namespace Model\Services;

class FAQRepository extends Repository
{

    public function create( $text, $placement )
    {
        $mapper = $this->getMapper();
        $faq = $mapper->build( $this->entityName );
        $faq->placement = $placement;
        $faq->text = $text;
        $mapper->create( $faq );

        return $faq;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $faqs = $mapper->mapAll();

        return $faqs;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $faq = $mapper->build( $this->entityName );
        $mapper->mapFromID( $faq, $id );

        return $faq;
    }

}
