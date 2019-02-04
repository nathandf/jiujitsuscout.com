$( function() {

    $( "#master-checkbox" ).on( "click", function() {
        if ( $( "#master-checkbox" ).prop( "checked" ) ) {
            $( ".action-cb" ).prop( "checked", true );
        } else {
            $( ".action-cb" ).prop( "checked", false );
        }
    } );

    $( "#lead-actions-button" ).on( "click", function () {
        $( "#actions-lead-modal" ).toggle();
    } );

    $( ".action-button" ).on( "click", function () {
        $( ".actions-modal" ).hide();
    } );

} );
