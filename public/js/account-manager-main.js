$( function () {
	$( "#account-manager-menu-button" ).on( "click", function () {
		$( "#account-manager-menu-modal" ).show();
	} );

	$( "#user-self-delete" ).on( "click", function () {
		confirmation = confirm( "Deleting your account is PERMANENT! Are your sure you want to continue" );
        if ( confirmation === false ) {
            event.preventDefault();
        }
	} );
} );
