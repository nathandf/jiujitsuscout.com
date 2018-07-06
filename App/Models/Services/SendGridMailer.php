<?php

namespace Models\Services;

use Contracts\MailerAPIInterface;

class SendGridMailer implements MailerAPIInterface
{
  private $recipient_name;
  private $recipient_email_address;
  private $sender_name;
  private $sender_email_address;
  private $content_type;
  private $email_subject;
  private $email_body;
  private $api_key;
  private $api_secret;

  public function __construct( \Conf\Config $config )
  {
    $this->setApiKey( $config::$configs[ "sendgrid" ][ "api_key" ] );
  }

  public function mail()
  {
    $from = new \SendGrid\Email( $this->sender_name, $this->sender_email_address );
    $to = new \SendGrid\Email( $this->recipient_name, $this->recipient_email_address );
    $content = new \SendGrid\Content( $this->content_type, $this->email_body );
    $mail = new \SendGrid\Mail( $from, $this->email_subject, $to, $content );
    $sg = new \SendGrid( $this->api_key );
    $response = $sg->client->mail()->send()->post( $mail );
    return $response->statusCode();
  }

  public function setRecipientName( $name )
  {
    $this->recipient_name = $name;
  }

  public function setRecipientEmailAddress( $email )
  {
    $this->recipient_email_address = $email;
  }

  public function setSenderName( $name )
  {
    $this->sender_name = $name;
  }

  public function setSenderEmailAddress( $email )
  {
    $this->sender_email_address = $email;
  }

  public function setContentType( $content_type )
  {
    $this->content_type = $content_type;
  }

  public function setEmailSubject( $subject )
  {
    $this->email_subject = $subject;
  }

  public function setEmailBody( $body )
  {
    $this->email_body = $body;
  }

  public function setApiKey( $key )
  {
    $this->api_key = $key;
  }

  public function setApiSecret( $secret )
  {
    $this->api_secret = $secret;
  }
}
