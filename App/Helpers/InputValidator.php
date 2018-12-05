<?php

namespace Helpers;

class InputValidator
{
	private $required_fields = [];
	public $errors = [];

	public function requireFields( array $fields )
	{
		$this->required_fields = $fields;
	}

	public function validate( Input $input, array $fields, $error_index )
	{
		foreach ( $fields as $field => $rules ) {
			// Grabbing data from the input for specified field if field is set
			// Prepare data for validation. N-Depth
			$value = $this->prepare( $input->get( $field ) );
			// Rules must be an array. If not, throw an Exception
			if ( is_array( $rules ) ) {
				foreach ( $rules as $rule => $rule_value ) {
					// Setting a name of the field to $field unless a custom field name is specified
					$field_name = $field;
					if ( in_array( "name", $rules ) && !empty( $rules[ "name" ] ) ) {
						$field_name = $rules[ "name" ];
					}
					// Check if rule is required and the value is not empty. If required and empty, add to errors
					if ( $rule == "required" && empty( $value ) && $value == "" ) {
						$this->addError( $error_index, "{$field_name} is a required field" );
					} elseif ( !empty( $value ) ) {
						switch ( $rule ) {
							case "min":
								if ( !$this->isMin( $value, $rule_value ) ) {
									$this->addError( $error_index, "{$field_name} must be more than {$rule_value} characters" );
								}
								break;
							case "max":
								if ( !$this->isMax( $value, $rule_value ) ) {
									$this->addError( $error_index, "{$field_name} must be less than {$rule_value} characters" );
								}
								break;
							case "matches":
								if ( $value != $input->data[ $rule_value ] ) {
									$this->addError( $error_index, "{$field_name} must match {$rule_value}" );
								}
								break;
							case "numeric":
								if ( !is_numeric( $value ) ) {
									$this->addError( $error_index, "{$field_name} must not contain any letters or special characters" );
								}
								break;
							case "phone":
								if ( preg_match( "/[^0-9.\-() +]/", $value ) ) {
									$this->addError( $error_index, "{$field_name} only allows for numbers and following characters \"+ . - ( )\"" );
								}
								break;
							case "strict-alpha-numeric":
								if ( !ctype_alnum( $value ) ) {
									$this->addError( $error_index, "{$field_name} must be alphanumeric characters only" );
								}
								break;
							case "uri":
								if ( preg_match( "/[^a-zA-Z0-9_\-]+/", $value ) ) {
									$this->addError( $error_index, "{$field_name} can only contain alphanumeric characters, dashes ( - ), and underscores ( _ )" );
								}
								break;
							case "email":
								if ( !filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
									$this->addError( $error_index, "{$field_name} must be a valid email address" );
								}
								break;
							case "url":
								if ( !filter_var( $value, FILTER_VALIDATE_URL ) ) {
									$this->addError( $error_index, "{$field_name} is not a valid URL" );
								}
								break;
							case "equals":
								if ( $value != $rule_value ) {
									$this->addError( $error_index, "{$field_name} doesn't have the correct value" );
								}
								break;
							case "equals-hidden":
								if ( $value != $rule_value ) {
									$this->addError( $error_index, "Please resubmit form" );
								}
								break;
							case "unique":
								if ( is_array( $rule_value ) ) {
									if ( in_array( $value, $rule_value ) ) {
										$this->addError( $error_index, "{$field_name} is already in use. Please try again" );
									}
								} else {
									// Throw an Exception if rule_value is not an array
									throw new \Exception( "rule_value must be of type 'array'" );
								}
								break;
							case "unique-discrete":
								if ( is_array( $rule_value ) ) {
									if ( in_array( $value, $rule_value ) ) {
										$this->addError( $error_index, "Please try another value for {$field_name}" );
									}
								} else {
									// Throw an Exception if rule_value is not an array
									throw new \Exception( "rule_value must be of type 'array'" );
								}
								break;
                            case "in_array":
                                if ( !in_array( $value, $rule_value ) ) {
                                    $this->addError( $error_index,"{$field_name} is not valid" );
                                }
								break;
							case "is_array":
                                if ( !is_array( $value ) ) {
                                    $this->addError( $error_index,"{$field_name} is not valid" );
                                }
								break;
							case "required-empty":
                                if ( $value != "" ) {
                                    $this->addError( $error_index,"{$field_name} is not valid" );
                                }
								break;
							case "rule-value-true":
                                if ( !$rule_value ) {
                                    $this->addError( $error_index,"{$field_name} is not valid" );
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

		if ( count( $this->getErrors( $error_index ) ) < 1 ) {
			return true;
		}

		return false;
	}

	public function addError( $error_index, $error_message )
	{
		$this->errors[ $error_index ][] = $error_message;
	}

	public function getErrors( $error_index = null )
	{
		if ( !is_null( $error_index ) && !empty( $this->errors[ $error_index ] ) ) {
			return $this->errors[ $error_index ];
		}

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

	private function prepareArray( array $data )
	{
		foreach ( $data as $key => $data_item ) {
			if ( is_array( $data_item ) ) {
				$data[ $key ] = $this->prepareArray( $data_item );
			} else {
				$data[ $key ] = $this->prepare( $data_item );
			}
		}

		return $data;
	}

	private function prepare( $data )
	{
		if ( is_array( $data ) ) {
			$data = $this->prepareArray( $data );
		} else {
			$data = trim( $data );
			$data = str_replace( "-", "_", $data );
		}

		return $data;
	}

}
