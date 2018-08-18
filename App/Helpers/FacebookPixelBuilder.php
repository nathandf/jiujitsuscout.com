<?php

namespace Helpers;

class FacebookPixelBuilder
{
	public $pixel;
	public $pixelID;
	public $events = [];

	public function addEvent( $events )
	{
		if ( is_array( $events ) ) {
			foreach ( $events as $event ) {
				$this->events[] = $event;
			}

			return;
		}

		// If not an array, add the single event to the events array
		$this->events[] = "fbq('track', '{$events}'); \n";

		return;
	}

	private function getEvents()
	{
		return $this->events;
	}

	public function setPixelID( $pixelID )
	{
		$this->pixelID = $pixelID;
	}

	public function getPixelID()
	{
		if ( !isset( $this->pixelID ) ) {
			throw new \Exception( "Facebook Pixel ID not set" );
		}

		return $this->pixelID;
	}

	public function build() {

		$pixelCodeTop =
			"<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '{$this->getPixelID()}'); // Insert your pixel ID here.
			fbq('track', 'PageView'); ";

		$pixelCodeBottom =
			"</script>
			<noscript><img height=\"1\" width=\"1\" style=\"display:none\"
			src=\"https://www.facebook.com/tr?id={$this->getPixelID()}&ev=PageView&noscript=1\"
			/></noscript>
			<!-- DO NOT MODIFY -->
			<!-- End Facebook Pixel Code -->";

		$pixelCodeEvents = "";

		foreach ( $this->events as $event ) {
			$pixelCodeEvents = $pixelCodeEvents . "fbq('track', '{$event}'); \n";
		}

		$pixel = $pixelCodeTop . "\n" . $pixelCodeEvents . $pixelCodeBottom;

		return $pixel;
    }
}
