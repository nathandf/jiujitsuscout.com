var QuestionnaireDispatcher  = {
    question_ids: null,
	total_questions: null,
	current_question_id: null,
	current_question_index: null,
	active_question_html_id: null,
	active_form_html_id: null,
	active_submit_button_html_id: null,
    active_question_choice_label_class: null,
    active_question_choice_input_class: null,

	dispatch: function ( question_ids, last_question_id ) {
        this.setQuestionIDs( question_ids );
        this.setTotalQuestions();

        if ( this.question_ids.indexOf( last_question_id.toString() ) >= this.total_questions - 1 ) {
            this.hideQuestionnaire();
            
            return;
        }

        if ( last_question_id == null ) {
            this.setCurrentQuestionID( this.question_ids[ 0 ] );
            this.setCurrentQuestionIndex();
        } else {
            last_question_index = this.question_ids.indexOf( last_question_id.toString() );
            this.current_question_index = last_question_index + 1;
            current_question_id = this.question_ids[ this.current_question_index ];
            this.setCurrentQuestionID( current_question_id );
        }

        this.setActiveQuestionHTMLID();
        this.showQuestion();
        this.setActiveQuestionChoiceLabelClass();
        this.setActiveQuestionChoiceInputClass();
        this.setActiveFormHTMLID();
        this.setActiveSubmitButtonID();
	},

    setQuestionIDs: function ( question_ids ) {
		this.question_ids = question_ids;
    },

	getQuestionID: function ( index ) {
		return this.question_ids[ index ];
	},

	setTotalQuestions: function () {
		this.total_questions = this.question_ids.length;
	},

	setCurrentQuestionID: function ( current_question_id ) {
		this.current_question_id = current_question_id;
	},

	setCurrentQuestionIndex: function () {
		this.current_question_index = this.question_ids.indexOf(
			this.current_question_id.toString()
		)
	},

	setActiveQuestionHTMLID: function () {
		this.active_question_html_id = "#question_" + this.current_question_id;
	},

	setActiveFormHTMLID: function () {
		this.active_form_html_id = "#question_form_" + this.current_question_id;
	},

    setActiveQuestionChoiceLabelClass: function () {
		this.active_question_choice_label_class = ".question-choice-label-" + this.current_question_id;
	},

    setActiveQuestionChoiceInputClass: function () {
		this.active_question_choice_input_class = ".question-choice-input-" + this.current_question_id;
	},

	setActiveSubmitButtonID: function () {
		this.active_submit_button_html_id = "#question_submit_" + this.current_question_id;
	},

    showQuestion: function () {
        $( this.active_question_html_id ).show();
    },

    hideQuestion: function () {
        // Hide the answered question
        $( this.active_question_html_id ).hide();
    },

    hideQuestionnaire: function () {
        $( ".questionnaire" ).hide();
    },

	nextQuestion: function () {
		this.current_question_index++;
		this.setCurrentQuestionID( this.getQuestionID( this.current_question_index ) );
		this.setCurrentQuestionIndex();
		this.setActiveQuestionHTMLID();
        this.setActiveQuestionChoiceLabelClass();
        this.setActiveQuestionChoiceInputClass();
		this.setActiveFormHTMLID();
		this.setActiveSubmitButtonID();
	},

    // Submit for asynch
    ajaxSubmitFormByID: function ( form_id, url, ajax_type = "POST" ) {
        $( form_id ).submit( function( e ) {
            e.preventDefault();
            $.ajax({
                type : ajax_type,
                url : url,
                data : $( form_id ).serialize(),
                beforeSend : function() {
                    //
                },
                success : function( response ) {
                    //
                },
                error : function() {
                    alert( "Something went wrong." );
                }
            });
            e.preventDefault();
        });
    },

    toggleSubmitButton: function ( event ) {
        var selected = 0;

        if ( !$( event.target ).hasClass( "input-selected" ) ) {
            $( event.target ).addClass( "input-selected" );
        } else {
            $( event.target ).removeClass( "input-selected" );
        }

        $( this.active_question_choice_label_class ).each( function () {
            if ( $( this ).hasClass( "input-selected" ) ) {
                selected++;
            }
        } );

        if ( selected > 0 ) {
            $( this.active_submit_button_html_id ).show();
            return;
        }

        $( this.active_submit_button_html_id ).hide();
        return;
    },

    submitQuestionAnswer: function ( url, ajax_type = "POST" ) {
        // Submit form to desitination url
        this.ajaxSubmitFormByID( this.active_form_html_id, url, ajax_type );

        this.hideQuestion();

        // If there are no more questions, hide the questionnaire
        if ( this.current_question_index == this.total_questions - 1) {
            this.hideQuestionnaire();
            return;
        }

        // Set the new html ids
        this.nextQuestion();

        // Show next question
        this.showQuestion();

        return;
    },
};
