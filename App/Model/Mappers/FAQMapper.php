<?php

namespace Model\Mappers;

class FAQMapper extends DataMapper
{
    public function create( \Model\FAQ $faq )
    {
        $id = $this->insert(
            "faq",
            [ "text" ],
            [ $faq->text ]
        );

        $faq->id = $id;

        return $faq;
    }

    public function mapAll()
    {
        $faqs = [];
        $sql = $this->DB->prepare( "SELECT * FROM faq" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $faq = $this->entityFactory->build( "FAQ" );
            $this->populate( $faq, $resp );
            $faqs[] = $faq;
        }

        return $faqs;
    }

    public function mapFromID( \Model\FAQ $faq, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM faq WHERE id = :id ORDER BY placement ASC" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $faq, $resp );

        return $faq;
    }
}
