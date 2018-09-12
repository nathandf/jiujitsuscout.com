$( function () {
	$( ".free-class-button" ).on( "click", function () {
		$( ".free-class-modal" ).show();
	} );

	$( ".free-class-modal-close" ).on( "click", function () {
		$( ".free-class-modal" ).hide();
	} );
} );
