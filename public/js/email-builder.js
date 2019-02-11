$( function () {
	// Insert Image Picker Widget
	$( ".insert-image-picker-image" ).on( "click", function () {
		$( "#email-body" ).replaceSelectedText( "[*img" + this.dataset.id + "*]" );
		$( "#insert-image-picker-modal" ).hide();
	} );

	$( "#choose-insert-image" ).on( "click", function () {
		$( "#insert-image-picker-modal" ).show();
	} );

	$( "#insert-image-picker-close" ).on( "click", function () {
		$( "#insert-image-picker-modal" ).hide();
	} );

	// Insert video Picker Widget
	$( ".insert-video-picker-video" ).on( "click", function () {
		$( "#email-body" ).replaceSelectedText( "[*video" + this.dataset.id + "*]" );
		$( "#insert-video-picker-modal" ).hide();
	} );

	$( "#choose-insert-video" ).on( "click", function () {
		$( "#insert-video-picker-modal" ).show();
	} );

	$( "#insert-video-picker-close" ).on( "click", function () {
		$( "#insert-video-picker-modal" ).hide();
	} );
} );
