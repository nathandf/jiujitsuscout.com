$( function () {
	$( "#required-checkbox" ).on( "click", function () {
		$( ".element-required-input" ).val( $( "#required-checkbox" ).prop( "checked" ) );
	} );

	$( "#element-selector" ).on( "change", function () {
		$( "#embeddable-form-element-type-id-input" ).val( $( this ).val() );
		$( "#add-field" ).submit();
	} );
} );
