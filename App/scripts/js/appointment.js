$( function() {

  $( "#reschedule" ).on( "click", function() {
    $( "#reschedule-modal" ).toggle();
  } );

  $( "#reschedule-modal-close" ).on( "click", function() {
    $( "#reschedule-modal" ).toggle();
  } );

} );
