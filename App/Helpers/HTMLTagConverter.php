<?php

namespace Helpers;

class HTMLTagConverter
{

	public function replaceTags( $string )
	{
		// This pattern will match anything that:
		// starts with "[*" followed by a word of from 1 to 2 chars long
		// may be followed by 1 space and then the word href=
		// followed by double quotes that may be empty or contain a url. "" or "http://www.whaterver.com/?query=foo"
		// followed by "*]" which is then followed by any word(s) that do not contain brakets or braces
		// followed by "[*" followed by 1 forward slash followed by a word of from 1 to 2 chars long
		// followed by "*]"
		// Examples:
		// ~ [*a href="somesite.com/hello.php"*]Some Text Here[*/a*]
		// ~ [*p*]Some super long text here[*/p*]
		$openingPattern = "/\[\*(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img)( [a-zA-Z\-]*=\"[a-zA-Z0-9:\/\.\-\_%=?]*\")*\*\]/";
		$closingPattern = "/\[\*\/(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img)\*\]/";

		// Replace openings
		$string = preg_replace( $openingPattern, "<\\1\\2>", trim( $string ) );

		// Replace closings
		$string = preg_replace( $closingPattern, "</\\1>", trim( $string ) );

		return $string;
	}

	public function replaceHTML( $string )
	{
		// Same as tagPattern but [* and *] are replaced by < and >
		$openingPattern = "/<(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img)( [a-zA-Z\-]*=\"[a-zA-Z0-9:\/\.\-\_%=?]*\")*>/";
		$closingPattern = "/<\/(a|p|i|b|h1|h2|h3|h4|h5|h6|em|strong|mark|ul|ol|li|u|img)>/";

		// Replace openings
		$string = preg_replace( $openingPattern, "[*\\1\\2*]", trim( $string ) );
		// Replace closings
		$string = preg_replace( $closingPattern, "[*/\\1*]", trim ( $string ) );

		return $string;
	}
}
