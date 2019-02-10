<?php

namespace Model\Services;

class TaskEmailBuilder
{
    private $body;
    private $subject

    public function build( $priority, $task_type_id )
    {
        // TODO build email
    }

    private function setSubject( $subject )
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        if ( isset( $this->subject ) === false ) {
            throw new \Exception( "Subject is not set" );
        }

        return $this->subject;
    }

    private function setBody( $body )
    {
        $this->body = $body;
    }

    public function getBody()
    {
        if ( isset( $this->body ) === false ) {
            throw new \Exception( "Body is not set" );
        }

        return $this->body;
    }
}
