<?php

namespace Contracts;

interface GeocoderInterface
{
	public function getGeoInfoByAddress( $address );
}
