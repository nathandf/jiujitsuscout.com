<?php

namespace Helpers;

class AccessControl
{
    public $available_roles = [
        "owner",
        "administrator",
        "manager",
        "standard"
    ];

    public function hasAccess( array $required_roles, $user_role )
    {
        $this->validateRoles( $required_roles );
        if ( !in_array( $user_role, $required_roles ) ) {
            return false;
        }

        return true;
    }

    public function validateRoles( array $roles )
    {
        foreach ( $roles as $role ) {
            if ( !in_array( $role, $this->available_roles ) ) {
                throw new \Exception( "{$role} is not one of the available roles" );
            }
        }
    }

    public function getRoles()
    {
        return $this->available_roles;
    }
}
