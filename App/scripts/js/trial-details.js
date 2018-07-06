$( function() {
  $( "#specific-end-date-select" ).change( function() {
      	$( "#specific-end-date" ).toggle();
        $( "#trial-length" ).toggle();
        if ( $( "#trial-length" ).css( "display" ) == "none" ) {
          $( "#quantity" ).prop( "required", false );
        } else {
          $( "#quantity" ).prop( "required", true );
        }
    });
});
