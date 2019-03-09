$( function () {
	if ( QuestionnaireDispatcher.questionnaire_complete ) {
		$( ".questionnaire" ).hide();
	} else {
		$( ".questionnaire" ).show();
	}
} );
