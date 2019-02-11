$( function() {
    $( ".sequence-dropdown-toggle" ).on( "click", function () {
        var tag_id = "#" + $( this ).parent().attr( "id" );
        var dropdown_id = tag_id + "-dropdown";
        $( dropdown_id ).toggle();
    } );

    $( ".start-time-toggle" ).change( function() {
        var select_time_container_id = "#" + $( this ).parent().attr( "id" ) + "-time-select";
        $( select_time_container_id ).toggle();
    });
} );
