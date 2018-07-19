$( function() {

  $( "#master-checkbox" ).on( "click", function() {
    if ( $( "#master-checkbox" ).prop( "checked" ) ) {
      $( ".action-cb" ).prop( "checked", true );
    } else {
      $( ".action-cb" ).prop( "checked", false );
    }
  } );

  $( "#send-sms" ).on( "click", function() {
    $( "#quick-text-modal" ).toggle();
  } );

  $( "#quick-text-modal-close" ).on( "click", function() {
    $( "#quick-text-modal" ).toggle();
  } );

  $( "#send-email" ).on( "click", function() {
    $( "#quick-email-modal" ).toggle();
  } );

  $( "#quick-email-modal-close" ).on( "click", function() {
    $( "#quick-email-modal" ).toggle();
  } );

} );
