<?php

namespace Model\Services;

class TaskEmailBuilder
{
    private $body;
    private $subject;
    private $prospects = [];
    private $members = [];

    private $email_html =

    '<div style="box-sizing: border-box; width: 100%; padding-top: 25px; padding-bottom: 25px; white-space: nowrap;">
    	<div style="max-width: 600px; margin: 0 auto; display: block; box-sizing: border-box; border-radius: 3px; border: 2px solid #CCCCCC; background: #F6F7F9;">
    		<h2 style="font-weight: 900; text-align: center; color: #FFF; background: #4A148C; padding: 20px; margin: 0 auto;">Task Due</h2>
    		<div style="padding: 15px;">
    			<div style="margin-top: 20px;"></div>
    			<p style="font-size: 22px; white-space: pre-wrap; font-weight: 600; margin: 0 auto; width: 100%;">{{task_title}}</p>
                <p style="font-size: 10px; font-weight: 600; margin-top: 20px; margin-bottom: 0px; word-wrap: break-word;">Description:</p>
    			<p style="white-space: pre-wrap; font-size: 16px; margin: 0 auto; width: 100%;">{{task_message}}</p>
    			<div style="margin-top: 20px; margin-bottom: 20px;">
    				<div style="width: 100%; box-sizing: border-box; border-top: 1px solid #CCCCCC;"></div>
    			</div>
    			<p style="white-space: pre-wrap;">{{prospect_string}}</p>
    			<p style="white-space: pre-wrap;">{{member_string}}</p>
    			<a href="https://www.jiujitsuscout.com/account-manager/business/task/{{task_id}}/" style="background: #4A148C; color: #FFFFFF; text-align: center; box-sizing: border-box; border-radius: 3px; display: block; width: 75%; padding: 15px; font-size: 18px; font-weight: 600; text-decoration: none; margin: 0 auto; margin-top: 20px;">View Task</a>
            </div>
    	</div>
    </div>';

    public function build()
    {
        $task = $this->getTask();
        $this->buildSubject( $task );
        $this->buildBody( $task );
    }

    private function buildSubject( $task )
    {
        $subject = "Task Due - {$task->title}";

        // Different messages by task type
        switch ( $task->task_type_id ) {
            case 1:
                break;
            case 2:
                $subject = "Contact Immediately - {$task->title}";
                break;
            case 3:
                $subject = "Make a call - {$task->title}";
                break;
            case 4:
                $subject = "Send a text message - {$task->title}";
                break;
            case 5:
                $subject = "Trial membership - Contact Immediately - {$task->title}";
                break;
            case 6:
                $subject = "Check up required - {$task->title}";
                break;
        }

        // Priority
        if ( strtolower( $task->priority ) == "critical" ) {
            $subject = "CRITICAL! - " . $subject;
        }

        $this->setSubject( $subject );
    }

    private function buildBody( $task )
    {
        $prospect_string = $this->buildProspectString();
        $member_string = $this->buildMemberString();

        $body = preg_replace( "/\{\{prospect_string\}\}/", $prospect_string, $this->email_html );
        $body = preg_replace( "/\{\{member_string\}\}/", $member_string, $body );
        $body = preg_replace( "/\{\{task_title\}\}/", $task->title, $body );
        $body = preg_replace( "/\{\{task_message\}\}/", $task->message, $body );
        $body = preg_replace( "/\{\{task_id\}\}/", $task->id, $body );

        // vdumpd($body);
        $this->setBody( $body );
    }

    private function buildProspectString()
    {
        $prospect_string = "";
        $prospect_names = [];
        if ( !empty( $this->prospects ) ) {
            foreach ( $this->prospects as $prospect ) {
                $prospect_names[] = $prospect->getFullName();
            }

            $prospect_string = implode( ", ", $prospect_names );

            return "Leads: " . $prospect_string;
        }

        return $prospect_string;
    }

    private function buildMemberString()
    {
        $member_string = "";
        $member_names = [];

        if ( !empty( $this->members ) ) {
            foreach ( $this->members as $member ) {
                $member_names[] = $member->getFullName();
            }

            $member_string = implode( ", ", $member_names );

            return "Members: " . $member_string;
        }

        return $member_string;
    }

    public function setTask( \Model\Task $task  )
    {
        $this->task = $task;
        return $this;
    }

    private function getTask()
    {
        if ( isset( $this->task ) === false ) {
            throw new \Exception( "Task is not set" );
        }

        return $this->task;
    }

    private function setSubject( $subject )
    {
        $this->subject = $subject;
        return $this;
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
        return $this;
    }

    public function getBody()
    {
        if ( isset( $this->body ) === false ) {
            throw new \Exception( "Body is not set" );
        }

        return $this->body;
    }

    public function addProspects( array $prospects )
    {
        foreach ( $prospects as $prospect ) {
            $this->addProspect( $prospect );
        }
    }

    private function addProspect( \Model\Person $prospect )
    {
        $this->prospects[] = $prospect;
    }

    public function addMembers( array $members )
    {
        foreach ( $members as $member ) {
            $this->addMember( $member );
        }
    }

    private function addMember( \Model\Person $member )
    {
        $this->members[] = $member;
    }
}
