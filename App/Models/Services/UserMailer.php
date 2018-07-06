<?php

namespace Models\Services;

class UserMailer
{

    public $mailer;

    public function __construct( \Contracts\MailerInterface $mailer )
    {
        $this->setMailer( $mailer );
    }

    public function setMailer( $mailer )
    {
        $this->mailer = $mailer;
    }

    public function sendWelcomeEmail( $first_name, $email )
    {
        $this->mailer->setRecipientName( $first_name );
        $this->mailer->setRecipientEmailAddress( $email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "partnersupport@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Welcome to JiuJitsuScout!" );
        $this->mailer->setEmailBody( "Your profile on JiuJitsuScout is complete!" );
        #$this->mailer->mail();

        return true;
    }

    public function sendLeadCaptureNotification( $user_first_name, $email, $prospect, $additional_info )
    {
        $this->mailer->setRecipientName( $user_first_name );
        $this->mailer->setRecipientEmailAddress( $email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "notifications@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Lead Captured" );
        $this->mailer->setEmailBody( "
            <p><b>Name: </b>{$prospect->first_name}</p>
            <p><b>Email: </b>{$prospect->email}</p>
            <p><b>Phone Number: </b>{$prospect->phone_number}</p>
            <p><b>Additional Info: </b>{$additional_info}</p><br>
            <a href='localhost/develop.jiujitsuscout.com/account-manager/business/lead/{$prospect->id}/'>View in Account Manager</a>
        " );
        #$this->mailer->mail();

        return true;
    }

}
