<?php

namespace Helpers;

class FacebookPixelBuilder
{
	public $pixel;
	public $pixelID;
	public $pixel_ids = [];
	public $events = [ "PageView" ];
	public $custom_events = [];

	public function addEvent( $events )
	{
		if ( is_array( $events ) ) {
			foreach ( $events as $event ) {
				$this->events[] = $event;
			}

			return;
		}

		// If not an array, add the single event to the events array
		$this->events[] = $events;

		return;
	}

	public function addCustomEvent( $custom_events )
	{
		if ( is_array( $custom_events ) ) {
			foreach ( $custom_events as $custom_event ) {
				$this->custom_events[] = $custom_event;
			}

			return;
		}

		// If not an array, add the single custom_event to the custom_events array
		$this->custom_events[] = $custom_events;

		return;
	}

	private function getEvents()
	{
		return $this->events;
	}

	public function addPixelID( $pixel_ids )
	{
		if ( is_array( $pixel_ids ) ) {
			foreach ( $pixel_ids as $pixel_id ) {
				$this->pixel_ids[] = $pixel_id;
			}

			return $this;
		}

		$this->pixel_ids[] = $pixel_ids;

		return $this;
	}

	public function build() {

		$pixelCodeTop =
			"<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','https://connect.facebook.net/en_US/fbevents.js');";

		$pixelCodeInits = "";

		foreach ( $this->pixel_ids as $id ) {
			$pixelCodeInits = $pixelCodeInits . "fbq('init', '{$id}'); // Insert your pixel ID here." . "\n";
		}

		$pixelCodeBottom =
			"</script>
			<noscript><img height=\"1\" width=\"1\" style=\"display:none\"
			src=\"https://www.facebook.com/tr?id={$this->pixel_ids[ 0 ]}&ev=PageView&noscript=1\"
			/></noscript>
			<!-- DO NOT MODIFY -->
			<!-- End Facebook Pixel Code -->";

		$pixelCodeEvents = "";

		foreach ( $this->events as $event ) {
			$pixelCodeEvents = $pixelCodeEvents . "fbq('track', '{$event}'); \n";
		}

		$pixelCodeCustomEvents = "";

		foreach ( $this->custom_events as $custom_event ) {
			$pixelCodeCustomEvents = $pixelCodeCustomEvents . "fbq('trackCustom', '{$custom_event}'); \n";
		}

		$pixel = $pixelCodeTop . "\n" . $pixelCodeInits . "\n" . $pixelCodeEvents . $pixelCodeCustomEvents . "\n" . $pixelCodeBottom;

		return $pixel;
    }
}
