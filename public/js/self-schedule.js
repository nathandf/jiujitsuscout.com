$( function() {
    $( ".--adults" ).on( "click", function () {
        $( "#programs" ).fadeOut( function () {
            $( "#adults" ).show();
            $( ".--go-back" ).show();
        } );
    } );

    $( ".--kids" ).on( "click", function () {
        $( "#programs" ).fadeOut( function () {
            $( "#kids" ).show();
            $( ".--go-back" ).show();
        } );

    } );

    $( ".--go-back" ).on( "click", function () {
        $( ".--program" ).hide();
        $( "#programs" ).show();
        $( ".--go-back" ).hide();
    } );
} );
