<?php

namespace Contracts;

interface MailerInterface
{
    public function mail();

    public function setRecipientName( $name );

    public function setRecipientEmailAddress( $email );

    public function setSenderName( $name );

    public function setSenderEmailAddress( $email );

    public function setContentType( $content_type );

    public function setEmailSubject( $subject );

    public function setEmailBody( $body );
}
