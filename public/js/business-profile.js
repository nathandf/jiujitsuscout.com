$( function () {
	$( ".free-class-button" ).on( "click", function() {
		$( ".free-class-modal" ).show();
	} );

	$( ".free-class-modal-close" ).on( "click", function() {
		$( ".free-class-modal" ).hide();
	} );

	$( ".contact-business-button" ).on( "click", function() {
		if ( QuestionnaireDispatcher.questionnaire_complete ) {
			$( ".free-class-modal" ).show();
		}
	} );

	$( ".business-images-lightbox-link" ).on( "click", function() {
		$( ".business-images-lightbox" ).show();
	} );

	$( ".business-images-lightbox-close" ).on( "click", function () {
		$( ".business-images-lightbox" ).hide();
	} );

	$( ".reviews-lightbox-link" ).on( "click", function() {
		$( ".reviews-lightbox" ).show();
	} );

	$( ".reviews-lightbox-close" ).on( "click", function() {
		$( ".reviews-lightbox" ).hide();
	} );

	$( ".questionnaire-complete-button" ).on( "click", function() {
		$( ".free-class-modal" ).show();
	} );
} );
