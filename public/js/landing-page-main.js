$( function() {

  $( ".cta-button" ).on( "click", function() {
    $( ".modal-form" ).toggle();
    $('html, body').animate( {
        scrollTop: $( ".modal-form" ).offset().top
    }, 1000 );
  } );

} );
