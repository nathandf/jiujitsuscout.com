<?php

namespace Helpers;

class AccessControl
{
  public $required_roles;

  public function requireRoles( $roles )
  {
    $this->required_roles = $roles;
  }

  public function isAuthorized( $user_role )
  {
    if ( is_array( $this->required_roles ) ) {
      if ( !in_array( $user_role, $this->required_roles ) ) {
        return false;
      } else {
        return true;
      }
    } elseif ( $this->required_roles == "any" ) {
      return true;
    }

  }

}
