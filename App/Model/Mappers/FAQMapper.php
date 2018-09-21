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
        $entityFactory = $this->container->getService( "entity-factory" );
        $faqs = [];
        $sql = $this->DB->prepare( "SELECT * FROM faq" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $faq = $entityFactory->build( "FAQ" );
            $this->populateFAQ( $faq, $resp );
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
        $this->populateFAQ( $faq, $resp );
        return $faq;
    }

    private function populateFAQ( \Model\FAQ $faq, $data )
    {
        $faq->id = $data[ "id" ];
        $faq->placement = $data[ "placement" ];
        $faq->text = $data[ "text" ];
    }

}
