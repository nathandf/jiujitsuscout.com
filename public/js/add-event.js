$( function () {
	// Email event
	$( "#event-type-1" ).on( "click", function () {
		$( "#event-type-id" ).val( 1 );
		$( "#email-templates-container" ).show();
		$( "#text-message-templates-container" ).hide();
	} );

	// Text message event
	$( "#event-type-2" ).on( "click", function () {
		$( "#event-type-id" ).val( 2 );
		$( "#text-message-templates-container" ).show();
		$( "#email-templates-container" ).hide();
	} );

	// Submit form
	$( ".template-button" ).on( "click", function () {
		$( "#template-id-input" ).val( this.dataset.template_id );
		$( ".event-templates-container" ).hide();
		$( "#event-buttons-container" ).hide();
		$( "#add-wait-event-container" ).show();
	} );

	$( "#wait-checkbox" ).on( "change", function () {
		if ( $( "#add-wait-duration" ).val() == "false" ) {
			$( "#add-wait-duration" ).val( "true" );
		} else {
			$( "#add-wait-duration" ).val( "false" );
		}
		$( "#wait-duration-container" ).toggle();
	} );

	$( "#wait-duration" ).on( "keyup", function () {
		$( "#wait-duration-input" ).val( $( "#wait-duration" ).val() );
	} );

	$( "#wait-duration-interval" ).on( "change", function () {
		$( "#wait-duration-interval-input" ).val( $( this ).children( "option:selected" ).val() );
	} );

	$( "#finish-button" ).on( "click", function () {
		$( "#add-event-form" ).submit();
	} );
} );
