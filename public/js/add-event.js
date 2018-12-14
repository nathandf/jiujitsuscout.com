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
		$( "#add-event-form" ).submit();
	} );
} );
