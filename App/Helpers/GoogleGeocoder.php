<?php
namespace Helpers;
use Contracts\GeocoderInterface;
class GoogleGeocoder implements GeocoderInterface
{
    public $gateway;
    public $api_key;
    public function __construct( \Conf\Config $config )
    {
        $this->gateway = $config::$configs[ "google" ][ "geocoding_api" ][ "gateway" ];
        $this->api_key = $config::$configs[ "google" ][ "api_key" ];
    }
    public function getGeoInfoByAddress( $address )
    {
        $address  = urlencode( $address );
        $url      = "{$this->gateway}?address={$address}&key={$this->api_key}";
        //$curl = curl_init();
        //curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        //curl_setopt( $curl, CURLOPT_URL, $url );
        //$contents = curl_exec( $curl );
        //curl_close( $curl );
        $raw      = self::curl_file_get_contents( $url );
        $contents = json_decode( $raw );
        return $contents;
    }
    public function getAssocInfoByGeoInfo( $GeoInfo )
    {
        $rr                = $GeoInfo;
        $rr->city          = null;
        $rr->county        = null;
        $rr->country       = null;
        $rr->state         = null;
        $rr->street_number = null;
        $rr->street_name   = null;
        $rr->zip           = null;
        $rr->zip4          = null;
        $rr->subpremise    = null;
        if ( $GeoInfo->status == 'OK' ) {
            $ar = $GeoInfo->results[ 0 ]->address_components;
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
                            switch ( $vvii ) {
                                case ( 'locality' ):
                                    $rr->city = $lastn;
                                    break;
                                case ( 'administrative_area_level_2' ):
                                    $rr->county = $lastn;
                                    break;
                                case ( 'administrative_area_level_1' ):
                                    $rr->state = $lastnl;
                                    break;
                                case ( 'street_number' ):
                                    $rr->street_number = $lastn;
                                    break;
                                case ( 'route' ):
                                    $rr->street_name = $lastn;
                                    break;
                                case ( 'postal_code' ):
                                    $rr->zip = $lastn;
                                    break;
                                case ( 'postal_code_suffix' ):
                                    $rr->zip4 = $lastn;
                                    break;
                                case ( 'country' ):
                                    $rr->country = $lastnl;
                                    break;
                                case ( 'subpremise' ):
                                    $rr->subpremise = $lastn;
                                    break;
                            }
                        }
                    }
                }
            }
            $rr->Address = $rr->street_number . ' ' . $rr->street_name;
            if ( $rr->zip4 != null ) {
                $rr->zip .= '-' . $rr->zip4;
            }
            if ( $rr->subpremise != null ) {
                if ( is_numeric( $rr->subpremise ) ) {
                    $rr->Subpremise = "Ste " . $rr->subpremise;
                }
            }
            $rr->Formated = $rr->street_number . ' ' . $rr->street_name . ' ' . $rr->subpremise . "\n<br>" . $rr->city . ', ' . $rr->state . ' ' . $rr->zip . "\n<br>" . $rr->county;
            return $rr;
        } else {
            return false;
        }
    }
    static private function curl_file_get_contents( $URL )
    {
        $save_code = md5( $URL );
        $save_in   = __DIR__ . "/../../cache/" . substr( $save_code, 0, 2 ) . "/";
        if ( !is_dir( $save_in ) ) {
            mkdir( $save_in );
        }
        $ff = $save_in . $save_code . ".json";
        if ( file_exists( $ff ) ) {
            $raw = file_get_contents( $ff );
            $ja  = json_decode( $raw );
            if ( $ja === null ) {
                unlink( $ff );
            } else {
                return file_get_contents( $ff );
            }
        }
        if ( !is_writeable( $save_in ) ) {
            die( "Need write permission for " . $save_in . " AKA '" . realpath( $save_in ) . "'" );
        }
        $c = curl_init();
        curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $c, CURLOPT_URL, $URL );
        $contents = curl_exec( $c );
        curl_close( $c );
        if ( $contents ) {
            //save if its valid
            $resp = json_decode( $contents, true );
            if ( !isset( $resp[ 'error_message' ] ) ) {
                @file_put_contents( $ff, json_encode( $resp, true ) );
            } else {
                die( $contents );
            }
            return file_get_contents( $ff );
        } else {
            return false;
        }
    }
}