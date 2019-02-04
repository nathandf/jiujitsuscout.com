<?php

namespace Contracts;

interface MailerAPIInterface extends MailerInterface
{
    public function setApiKey( $key );
    public function setApiSecret( $secret );
}
