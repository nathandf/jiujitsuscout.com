<?php

namespace Model\Services;

class UserSMSMessager extends Service
{

  public function __construct( UserInterface $user, SMSMessagerInterface $smsMessager )
  {
    $this->user = $user;
    $this->message = $message;
  }

}
