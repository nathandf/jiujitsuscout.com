<?php

namespace Controllers\Webhooks;

use \Core\Controller;

class Twilio extends Controller
{
    public function statusCallback()
    {
        $input = $this->load( "input" );
        if ( $input->exists() ) {
            
        }
    }
}
