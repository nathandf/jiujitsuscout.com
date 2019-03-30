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
        $( ".question-submit-kids" ).hide();
        $( ".question-submit-adults" ).hide();
    } );

    $( ".question-choice" ).on( "click", function ( event ) {
        if ( $( this ).hasClass( "--kid-question-choice" ) ) {
            $( ".question-submit-kids" ).show();
        }
        if ( $( this ).hasClass( "--adult-question-choice" ) ) {
            $( ".question-submit-adults" ).show();
        }
    } );
} );
