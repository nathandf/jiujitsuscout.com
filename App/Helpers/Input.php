<?php

namespace Helpers;

class Input
{
    private $method;
    public $data;

    public function exists( $method = "post" )
    {
        if ( $method == "post" ) {
            if ( empty( $_POST ) ) {

                return false;
            } else {
                $this->setMethod( $method );
                $this->setData( $_POST );

                return true;
            }
        } elseif( $method == "get"  ) {
            if ( empty( $_GET ) ) {

                return false;
            } else {
                $this->setMethod( $method );
                $this->setData( $_GET );

                return true;
            }
        }

        return false;
    }

    /**
     * @param $index
     * @param int $filter_var_flag
     * @return mixed|string
     *
     * Grabs data from specified super global($_GET or $_POST), sanitizes it, and returns it.
     */
    public function get( $index, $filter_var_flag = FILTER_SANITIZE_FULL_SPECIAL_CHARS )
    {
        $request = $_POST; // default
        if ( $this->method == "get" ) {
            $request = $_GET;
        } elseif ( $this->method == "file" ) {
            $required = $_FILES;
        }
        if ( isset( $request[ $index ] ) ) {
            if ( is_array( $request[ $index ] ) && !is_null( $filter_var_flag ) ) {
                foreach ( $request[ $index ] as $key => $item ) {
                    $request[ $index ][ $key ] = filter_var( $item, $filter_var_flag );
                }
                return $request[ $index ];
            } else {
                return is_null( $filter_var_flag ) ? $request[ $index] : filter_var( $request[ $index ], $filter_var_flag );
            }
        } else {
            return "";
        }
    }

    public function issetMethod( $method )
    {
        switch ( $method ) {
            case "post":
                if ( !empty( $_POST ) ) {
                    return false;
                }
                break;
            case "get":
                if ( !empty( $_GET ) ) {
                    return false;
                }
                break;
            case "files":
            if ( !empty( $_FILES ) ) {
                return false;
            }
                break;
            case "server":
                if ( !empty( $_SERVER ) ) {
                    return false;
                }
                break;
        }

        return true;
    }

    public function issetField( $field )
    {
        $data = $this->getData();
        if ( isset( $data[ $field ] ) && !empty( $data[ $field ] ) ) {

            return true;
        }

        return false;
    }

    public function setData( array $data )
    {
        $this->data = $data;
    }

    private function getData()
    {
        if ( isset( $this->data ) ) {

            return $this->data;
        }

        return [];
    }

    public function addField( $index, $value )
    {
        if ( !empty( $this->data ) ) {
            $this->data[ $index ] = $value;

            return true;
        }

        return false;
    }

    public function setMethod( $method )
    {
        $this->method = $method;
    }

}
