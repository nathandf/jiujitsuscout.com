<?php

namespace Helpers;

class FormValidator
{
    private $fields_to_validate;
    private $required_fields;
    public $invalid_fields = [];
    public $errors = [];

    public function requireFields( array $fields )
    {
        $this->required_fields = $fields;
    }

    public function validate( Form $form, $fields, $allow_empty = false )
    {
        $this->resetInvalidFields( );
        $this->setFieldsToValidate( $fields );
        foreach ( $this->fields_to_validate as $field ) {
            if ( !$allow_empty ) {
                if ( !array_key_exists( $field, $form->data ) || empty( $form->data[ $field ] ) ) {
                    $this->invalid_fields[] = $field;
                }
            } else {
                if ( !array_key_exists( $field, $form->data ) ) {
                    $this->invalid_fields[] = $field;
                }
            }
        }
        if ( count( $this->invalid_fields ) < 1 ) {
            return true;
        }
        return false;
    }

    public function validateInput( Form $form, array $fields )
    {
        foreach ( $fields as $field => $rules ) {
            // Grabbing data from the form for specified field if field is set
            $value = trim( $form->get( $field ) );
            // Rules must be an array. If not, throw an Exception
            if ( is_array( $rules ) ) {
                foreach ( $rules as $rule => $rule_value ) {
                    // Check if rule is required and the value is not empty. If required and empty, add to errors
                    if ( $rule == "required" && empty( $value ) ) {
                        $this->addError( "{$field} is a required field" );
                    } elseif ( !empty( $value ) ) {
                        switch ( $rule ) {
                            case "min":
                                if ( !$this->isMin( $value, $rule_value ) ) {
                                    $this->addError( "{$field} must be more than {$rule_value} characters" );
                                }
                                break;
                            case "max":
                                if ( !$this->isMax( $value, $rule_value ) ) {
                                    $this->addError( "{$field} must be less than {$rule_value} characters" );
                                }
                                break;
                            case "matches":
                                if ( $value != $form->data[ $rule_value ] ) {
                                    $this->addError( "{$field} must match {$rule_value}" );
                                }
                                break;
                            case "numeric":
                                if ( !is_numeric( $value ) ) {
                                    $this->addError( "{$field} must not contain any letters or special characters" );
                                }
                                break;
                            case "email":
                                if ( !filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
                                    $this->addError( "{$field} must be a valid email address" );
                                }
                                break;
                            case "url":
                                if ( !filter_var( $value, FILTER_VALIDATE_URL ) ) {
                                    $this->addError( "{$field} is not a valid URL" );
                                }
                                break;
                            case "equals":
                                if ( $value != $rule_value ) {
                                    $this->addError( "{$field} doesn't have the correct value" );
                                }
                                break;
                            case "equals-hidden":
                                if ( $value != $rule_value ) {
                                    $this->addError( "{$field} value must not be changed." );
                                }
                                break;
                            case "owned":
                                if ( $value != $rule_value ) {
                                    $this->addError( "{$field} value must not be changed." );
                                }
                                break;
                        }
                    }
                }
            } else {
                // Throw an Exception if rules is not an array
                throw new \Exception( "Rules must be of type 'array'" );
            }
        }

        if ( count( $this->getErrors( ) ) < 1 ) {
            return true;
        }

        return false;
    }

    public function resetInvalidFields( )
    {
        $this->invalid_fields = [];
    }

    public function setFieldsToValidate( array $fields )
    {
        $this->fields_to_validate = $fields;
    }

    public function addError( $error_message )
    {
        $this->errors[] = $error_message;
    }

    public function getErrors( )
    {
        return $this->errors;
    }

    private function isMin( $value, $min )
    {
        if ( strlen( $value ) >= $min ) {
            return true;
        }
        return false;
    }

    private function isMax( $value, $max )
    {
        if ( strlen( $value ) <= $max ) {
            return true;
        }
        return false;
    }

}
