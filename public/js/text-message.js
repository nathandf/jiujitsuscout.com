$( function () {
	$( "#charCount" ).text( $( "#input-text-message-body" ).val().length );

	$( '#input-text-message-body' ).on( "keyup", function() {
		$( "#charCount" ).text( this.value.length );
		if ( this.value.length >= 0 && this.value.length <= 160 ) {
			$( "#charCount" ).css( "color", "green" );
		} else {
			$( "#charCount" ).css( "color", "red" );
		}
	});
} );
