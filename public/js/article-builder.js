$( function() {

	meta_title = $( "#input_meta_title" ).text();
	meta_description = $( "#input_meta_description" ).text();
	slug = $( "#input_slug" ).text();

	$( "#input_title" ).keyup( function() {
		if ( $( "#sluglock" ).prop( "checked" ) == false ) {
			$( "#input_slug" ).val( $( this ).val().toLowerCase().split( " " ).join( "-" ) );
		}
	});

	$( "#input_meta_title" ).on( "keyup", function() {
		input_meta_title = $( "#input_meta_title" ).val();
		$( "#meta_title" ).text( input_meta_title );
	});

	$( "#input_meta_description" ).on( "keyup", function() {
		input_meta_description = $( "#input_meta_description" ).val();
		$( "#meta_description" ).text( input_meta_description );
	});

	$( "#input_slug" ).on( "keyup", function() {
		input_slug = $( "#input_slug" ).val();
		$( "#slug" ).text( input_slug );
	});

} );
