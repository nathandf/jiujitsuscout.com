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
		$address = urlencode( $address );

		$url = "{$this->gateway}?address={$address}&key={$this->api_key}";

		$curl = curl_init();
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        curl_setopt( $curl, CURLOPT_URL, $url );

        $contents = curl_exec( $curl );

        curl_close( $curl );

		$contents = json_decode( $contents );

		return $contents;
	}
        public function getAssocInfoByGeoInfo($GeoInfo) {
            $rr              = $GeoInfo;
            $rr->city          = null;
                $rr->county        = null;
                $rr->country       = null;
                $rr->state         = null;
                $rr->street_number = null;
                $rr->street_name   = null;
                $rr->zip           = null;
                $rr->zip4          = null;
                $rr->subpremise    = null;
                if ( $GeoInfo->status  == 'OK' ) {
                $ar            = $GeoInfo->results[0]->address_components;
                
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
                                    $rr->city = $lastn;
                                }
                                if ( $vvii == 'administrative_area_level_2' ) {
                                    $rr->county = $lastn;
                                }
                                if ( $vvii == 'administrative_area_level_1' ) {
                                    $rr->state = $lastnl;
                                }
                                if ( $vvii == 'street_number' ) {
                                    $rr->street_number = $lastn;
                                }
                                if ( $vvii == 'route' ) {
                                    $rr->street_name = $lastn;
                                }
                                if ( $vvii == 'postal_code' ) {
                                    $rr->zip = $lastn;
                                }
                                if ( $vvii == 'postal_code_suffix' ) {
                                    $rr->zip4 = $lastn;
                                }
                                if ( $vvii == 'country' ) {
                                    $rr->country = $lastnl;
                                }
                                if ( $vvii == 'subpremise' ) {
                                    $rr->subpremise = $lastn;
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
}
