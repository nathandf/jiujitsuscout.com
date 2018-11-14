$( function() {
	$( "#marketing-consultation-button" ).on( "click", function () {
		$( "#marketing-consultation-modal" ).show();
	} );

	$( "#marketing-consultation-modal-close" ).on( "click", function () {
		$( "#marketing-consultation-modal" ).hide();
	} );
} );
