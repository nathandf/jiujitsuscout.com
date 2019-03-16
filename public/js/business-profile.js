$( function () {
	$( ".register-button" ).on( "click", function() {
		$( ".register-modal" ).show();
	} );

	$( ".register-modal-close" ).on( "click", function() {
		$( ".register-modal" ).hide();
	} );

	$( ".--trigger-register-modal" ).on( "click", function() {
		if ( QuestionnaireDispatcher.questionnaire_complete ) {
			$( ".register-modal" ).show();
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
		$( ".register-modal" ).show();
	} );
} );
