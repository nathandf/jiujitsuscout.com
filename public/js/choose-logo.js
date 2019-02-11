$( function () {
	$( "#choose-image-button" ).on( "click", function () {
		$( "#insert-image-picker-modal" ).show();
	} );

	$( ".insert-image-picker-image" ).on( "click", function () {
		$( "#image-display" ).attr( "src", this.dataset.src );
		$( "#input-image-id" ).val( this.dataset.id );
		$( "#image-picker-form" ).submit();
		$( "#insert-image-picker-modal" ).hide();
	} )
} );
