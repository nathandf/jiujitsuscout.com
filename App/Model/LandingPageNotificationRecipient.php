<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageNotificationRecipient implements EntityInterface
{
    public $id;
    public $landing_page_id;
    public $user_id;
}
