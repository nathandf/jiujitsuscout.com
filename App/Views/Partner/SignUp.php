<?php

$smarty->assign( "gymname", "" );
$smarty->assign( "on_form_gym_name", "your gym" );

if ( isset( $data ) ) {
  $smarty->assign( "gymname", $data[ 0 ][ "gym_name" ] );
  $smarty->assign( "on_form_gym_name", $data[ 0 ][ "gym_name" ] );
}

$error = "";
if ( isset( $data[ 0 ][ "error" ] ) ) {
  $error = $data[ 0 ][ "error" ];
}
$smarty->assign( "error", $error );
$smarty->display( "partner/sign-up.tpl" );
