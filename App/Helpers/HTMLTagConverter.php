<?php

namespace Helpers;

class HTMLTagConverter
{

	public function replaceTags( $string )
	{
		$openingPattern = "/\[\*(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img|button)( \w*=\"[^\<\>\[\]\{\}\(\)\']*\"\s?\/?)*\*\]/";
		$closingPattern = "/\[\*\/(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img|button)\*\]/";

		// Replace openings
		$string = preg_replace( $openingPattern, "<\\1\\2>", $string );

		// Replace closings
		$string = preg_replace( $closingPattern, "</\\1>", $string );

		return $string;
	}

	public function replaceHTML( $string )
	{
		$openingPattern = "/<(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img|button)( \w*=\"[^\<\>\[\]\{\}\(\)\']*\"\s?\/?)*>/";
		$closingPattern = "/<\/(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img|button)>/";

		// Replace openings
		$string = preg_replace( $openingPattern, "[*\\1\\2*]", $string );
		// Replace closings
		$string = preg_replace( $closingPattern, "[*/\\1*]", $string );

		return $string;
	}
}
