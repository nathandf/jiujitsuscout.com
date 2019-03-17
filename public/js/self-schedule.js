$( function() {
    $( ".--choose-program" ).on( "click", function () {
        $( "#programs" ).hide();
        $( ".--go-back" ).show();
    } );

    $( ".--adults" ).on( "click", function () {
        $( "#adults" ).show();
    } );

    $( ".--kids" ).on( "click", function () {
        $( "#kids" ).show();
    } );

    $( ".--go-back" ).on( "click", function () {
        $( ".--program" ).hide();
        $( "#programs" ).show();
        $( ".--go-back" ).hide();
    } );
} );
