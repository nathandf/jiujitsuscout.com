<?php

namespace Model\Services;

class EntityFactory
{
    public function build( $type, $namespace = "\\Model\\" )
    {
        if ( $type == "" ) {
            throw new \Exception( "Invalid Entity Type: \"$type\"." );
        }

        $class = $namespace . ucwords( $type );

        if ( class_exists( $class ) ) {
            return new $class();
        } else {
            throw new \Exception( "Class {$type}" );
        }
    }

    public function replicateEntity( \Contracts\EntityInterface $object )
    {
        $class = get_class( $object );
        return new $class();
    }
}
