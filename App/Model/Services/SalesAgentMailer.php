<?php

namespace Model\Services;

class SalesAgentMailer
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

    public function sendPartnerSignUpAlert( $name, $gymname, $email, $phone_number )
    {
        $this->mailer->setRecipientName( "JJS Agent" );
        $this->mailer->setRecipientEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setSenderName( "JJS Notification System" );
        $this->mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Sign Up on JiuJitsuScout" );
        $this->mailer->setEmailBody( "Name: $name<br>Business: $gymname.<br>Email: $email<br>Phone Number: $phone_number" );
        $this->mailer->mail();

        return true;
    }

    public function sendConsultationAlert( $name, $email, $phone_number, $budget = null, $students = null, $message = null )
    {
        $this->mailer->setRecipientName( "JJS Agent" );
        $this->mailer->setRecipientEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setSenderName( "JJS Notification System" );
        $this->mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Marketing Consultation Requested" );
        $this->mailer->setEmailBody( "Name: $name<br>Email: $email<br>Phone Number: $phone_number<br>Monthly Marketing Budget: $budget<br># of Students: $students<br>Message: $message" );
        $this->mailer->mail();

        return true;
    }

    public function sendAddBusinessAlert( $name, $gymname, $email, $phone_number )
    {
        $this->mailer->setRecipientName( "JJS Agent" );
        $this->mailer->setRecipientEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setSenderName( "JJS Notification System" );
        $this->mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Business Added" );
        $this->mailer->setEmailBody( "<b>$name</b> added a new business: <b>$gymname</b>.<br>Email: $email<br>Phone Number: $phone_number" );
        $this->mailer->mail();

        return true;
    }

    public function sendCampaignOrderAlert( $name, $gymname, $campaign_type, $email, $phone_number )
    {
        $this->mailer->setRecipientName( "JJS Agent" );
        $this->mailer->setRecipientEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setSenderName( "JJS Notification System" );
        $this->mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Campaign Order - $campaign_type" );
        $this->mailer->setEmailBody( "<b>$name</b> from <b>$gymname</b> ordered a new campaign.<br><b>Campaign Type: </b>$campaign_type<br><b>Contact Info</b><br>Email: $email<br>Phone Number: $phone_number" );
        $this->mailer->mail();

        return true;
    }

    public function sendServiceOrderNotification( $account_id, $product_name )
    {
        $this->mailer->setRecipientName( "JJS Agent" );
        $this->mailer->setRecipientEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setSenderName( "JJS Notification System" );
        $this->mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Service Order - {$product_name} - Account {$account_id}" );
        $this->mailer->setEmailBody( "
            New Service Order - {$product_name} - Account {$account_id}
        " );
        $this->mailer->mail();

        return true;
    }
}
