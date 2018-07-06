<?php

namespace Helpers;

class Geocoder
{
    static private $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&project=secret-meridian-183512&key=AIzaSyDf1NdHutID0uuwPsEjFBpnFWuCatdDCbg&address=";
    static public function getLocation( $address ) {
        $url       = self::$url . urlencode( $address );
        $resp_json = self::curl_file_get_contents( $url );
        $resp      = json_decode( $resp_json, true );
        if ( $resp[ 'status' ] == 'OK' ) {
            $ar   = $resp[ 'results' ][ 0 ][ 'address_components' ];
            $city = null;
            foreach ( $ar as $kk => $vv ) {
                foreach ( $vv as $kki => $vvi ) {
                    if ( $kki == "short_name" ) {
                        $lastn = $vvi;
                    }
                    if ( $kki == "types" ) {
                        foreach ( $vvi as $kkii => $vvii ) {
                            if ( $vvii == 'locality' ) {
                                $city = $lastn;
                            }
                        }
                    }
                }
            }
            $resp[ 'results' ][ 0 ][ 'geometry' ][ 'location' ][ 'city' ] = $city;
            //$resp['results'][0]['geometry']['location']['ar'] = $ar;
            //$resp['results'][0]['geometry']['location']['a'] = $resp;
            return $resp[ 'results' ][ 0 ][ 'geometry' ][ 'location' ];
        } else {
            return false;
        }
    }
    static public function getLocation_full( $address ) {
        $url       = self::$url . urlencode( $address );
        $resp_json = self::curl_file_get_contents( $url );
        $resp      = json_decode( $resp_json, true );
        if ( $resp[ 'status' ] == 'OK' ) {
            $ar            = $resp[ 'results' ][ 0 ][ 'address_components' ];
            $city          = null;
            $county        = null;
            $country       = null;
            $state         = null;
            $street_number = null;
            $street_name   = null;
            $zip           = null;
            $zip4          = null;
            foreach ( $ar as $kk => $vv ) {
                foreach ( $vv as $kki => $vvi ) {
                    if ( $kki == "short_name" ) {
                        $lastn = $vvi;
                    }
                    if ( $kki == "long_name" ) {
                        $lastnl = $vvi;
                    }
                    if ( $kki == "types" ) {
                        foreach ( $vvi as $kkii => $vvii ) {
                            if ( $vvii == 'locality' ) {
                                $city = $lastn;
                            }
                            if ( $vvii == 'administrative_area_level_2' ) {
                                $county = $lastn;
                            }
                            if ( $vvii == 'administrative_area_level_1' ) {
                                $state = $lastnl;
                            }
                            if ( $vvii == 'street_number' ) {
                                $street_number = $lastn;
                            }
                            if ( $vvii == 'route' ) {
                                $street_name = $lastn;
                            }
                            if ( $vvii == 'postal_code' ) {
                                $zip = $lastn;
                            }
                            if ( $vvii == 'postal_code_suffix' ) {
                                $zip4 = $lastn;
                            }
                            if ( $vvii == 'country' ) {
                                $country = $lastnl;
                            }
                        }
                    }
                }
            }
            //                $resp[ 'results' ][ 0 ][ 'geometry' ][ 'location' ][ 'city' ] = $city;
            //$resp['results'][0]['geometry']['location']['ar'] = $ar;
            //$resp['results'][0]['geometry']['location']['a'] = $resp;
            $rr              = $resp[ 'results' ][ 0 ][ 'geometry' ][ 'location' ];
            /*
            $rr[ 'street_number' ] = $street_number;
            $rr[ 'street_name' ]   = $street_name;
            */
            $rr[ 'Address' ] = $street_number . ' ' . $street_name;
            $rr[ 'City' ]    = $city;
            $rr[ 'State' ]   = $state;
            $rr[ 'Zip' ]     = $zip;
            if ( $zip4 != null ) {
                $rr[ 'Zip' ] .= '-' . $zip4;
            }
            $rr[ 'County' ]   = $county;
            $rr[ 'Country' ]  = $country;
            $rr[ 'RAW_URL' ]  = $resp[ 'RAW_URL' ];
            $rr[ 'C_F' ]      = $resp[ 'C_F' ];
            $rr[ 'Formated' ] = $street_number . ' ' . $street_name . "\n<br>" . $city . ', ' . $state . ' ' . $rr[ 'Zip' ] . "\n<br>" . $county;
            return $rr;
        } else {
            return false;
        }
    }
    static private function curl_file_get_contents( $URL ) {
        $ff = __DIR__ . "/../cache/" . md5( $URL ) . ".json";
        if ( file_exists( $ff ) ) {
            return file_get_contents( $ff );
        }
        if ( !is_writeable( __DIR__ . "/../cache/" ) ) {
            die( "Need write permission for " . __DIR__ . "/../cache/" );
        }
        $c = curl_init();
        curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $c, CURLOPT_URL, $URL );
        $contents = curl_exec( $c );
        curl_close( $c );
        if ( $contents ) {
            //save if its valid
            $resp              = json_decode( $contents, true );
            $resp[ 'RAW_URL' ] = urldecode( $URL );
            $resp[ 'C_F' ]     = $ff;
            if ( !isset( $resp[ 'error_message' ] ) ) {
                @file_put_contents( $ff, json_encode( $resp, true ) );
            } else {
                die( $contents );
            }
            return file_get_contents( $ff );
        } else {
            return FALSE;
        }
    }
}
