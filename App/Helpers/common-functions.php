<?php

// checks length of string, compares to maximum, cuts and adds ellipsis
function str_shortener( $string, $max_len = 0, $add_ellipsis = false, $allow_overflow = false) {
  $e = "...";
  if ( $max_len > 0 ) {
    if ( ( strlen( $string ) <= $max_len ) == false ) {
      if ( $add_ellipsis == true && $allow_overflow == false) {
        $string = substr( $string, 0, $max_len - 3 );
        $string = $string . $e;
      } elseif ( $add_ellipsis == true && $allow_overflow == true ) {
        $string = substr( $string, 0, $max_len );
        $string = $string . $e;
      } else {
        $string = substr( $string, 0, $max_len );
      }
    }
  }
  return $string;
}

function cleanName($string)
{
 $string = trim(preg_replace('/[^0-9a-zA-Z_\s]/', '', $string)); // Removes special chars.
 $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 return $string;
}

function cleanEmail($string)
{
 $string = trim(strtolower(str_replace(' ', '', $string))); // Removes special chars.
 return $string;
}

function cleanPhoneNumber($string)
{
 $string = trim( preg_replace( '/[^0-9a-zA-Z_\s]/', '', $string ) ); // Removes special chars.
 $string = str_replace(" ", "", $string);
 $string = str_replace("-", "", $string);
 return $string;
}

function CreateUniqueId(){
	$length = 13;
	$bytes = openssl_random_pseudo_bytes(ceil($length / 2));
	$id = uniqid(). "\t". substr(bin2hex($bytes), 0, $length);
	return $id;
}

function generate_token() {
  $token = md5( time() );
  return $token;
}

function vdump( $input ) {
  echo "<pre>";
  var_dump( $input );
  echo "</pre><br>";
}

function vdumpd( $input ) {
  echo "<pre>";
  var_dump( $input );
  echo "</pre><br>";
  die();
}

function echod( $input ) {
  echo $input;
  die();
}
