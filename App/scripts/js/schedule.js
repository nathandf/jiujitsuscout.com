$( function() {

    // "Add classes" button
    var addButton = $( "#add-classes-button" );
    // List of ids of class checkboxes
    var checkboxArray = [];

    $( "input[type=checkbox]" ).on( "click", function () {

        // Add and remove ids of the selected classes to checkboxArray
        if ( jQuery.inArray( $( this ).prop( "id" ), checkboxArray ) == "-1" ) {
            checkboxArray.push( $( this ).prop( "id" ) );
        } else {
            var index = checkboxArray.indexOf( $( this ).prop( "id" ) );
            checkboxArray.splice( index, 1 );
        }



        // Disable button when no classes are selected.
        if ( checkboxArray.length > 0 ) {
            addButton.prop( "disabled", false );
            addButton.removeClass( "btn-inline-disabled" );
            addButton.addClass( "btn-inline" );
        } else {
            addButton.prop( "disabled", true );
            addButton.removeClass( "btn-inline" );
            addButton.addClass( "btn-inline-disabled" );
        }


    } );

} );
