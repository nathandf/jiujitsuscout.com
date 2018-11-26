$( function() {
    $( ".--c-hide" ).on( "click", function() {
        $( this ).hide( );
    } );

    $( ".--c-logout" ).on( "click", function( event ) {
        confirmation = confirm( "Are you sure you want to logout?" );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-trash" ).on( "click", function( event ) {
        confirmation = confirm( "Are you sure you want to delete this?" );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-mp-confirm" ).on( "click", function( event ) {
        confirmation = confirm( "Confirm prospect to member conversion." );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-reject-prospect" ).on( "click", function( event ) {
        confirmation = confirm( "Are you sure your want to reject this lead? This action is permanent." );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-purchase" ).on( "click", function( event ) {
        confirmation = confirm( "Press OK to confirm your purchase." );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-status-confirm" ).on( "click", function( event ) {
        confirmation = confirm( "Confirm this status change." );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--c-send-confirm" ).on( "click", function( event ) {
        confirmation = confirm( "Press \"OK\" to confirm and send this email." );
        if ( confirmation === false ) {
            event.preventDefault();
        }
    } );

    $( ".--clickable" ).on( "click", function( event ) {
        if ( $( location ).attr( "hostname" ) == "www.jiujitsuscout.com" ) {
            $.post(
                "https://www.jiujitsuscout.com/tracking/record-click",
                {
                    "business_id": this.dataset.b_id,
                    "property": this.dataset.property,
                    "property_sub_type": this.dataset.property_sub_type,
                    "ip": this.dataset.ip
                }
            );
        }
    } );

    $( "input:file" ).change(
        function() {
            if ( $( this ).val() ) {
                $( ".file-upload-button" ).show();
                $( ".file-upload-field-container" ).show();
            }
        }
    );

    $( "#nav-dropdown-button" ).on( "click", function() {
        $( "#nav-items-container" ).slideToggle( 250 );
        $( "#nav-items-container" ).scrollTop();
    } );

    $( ".--c-advanced-options" ).on( "click", function() {
        $( "#advanced-options" ).slideToggle();
    } );

    $( "#create-account" ).on( "submit", function () {
        $( "#account-creation-loading-screen" ).show( "" );
    } );
} );
