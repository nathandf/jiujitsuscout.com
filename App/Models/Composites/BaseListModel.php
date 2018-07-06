<?php

namespace Models\Composites;

abstract class BaseListModel
{

  public function requireClass( $class_name, array $array )
  {
    foreach ( $array as $element ) {
      if ( !is_a( $element, $class_name ) ) {
        $element_type = gettype( $element );
        if ( $element_type == "object" ) {
          $element_type = get_class( $element );
        }
        throw new \Exception( "Class " . get_class( $this ) . " requires objects of class " . $class_name . ". Got " . $element_type );
      }
    }
  }

}
